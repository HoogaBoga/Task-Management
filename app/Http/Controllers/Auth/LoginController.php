<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supabaseUrl = config('services.supabase.url');
        $supabaseAnonKey = config('services.supabase.anon_key');

        if (!$supabaseUrl || !$supabaseAnonKey) {
            Log::error('Supabase credentials missing.');
            return redirect()->back()->with('error', 'Authentication service is misconfigured.')->withInput();
        }

        $authUrl = $supabaseUrl . '/auth/v1/token?grant_type=password';

        try {
            $response = Http::withHeaders([
                'apikey' => $supabaseAnonKey,
                'Content-Type' => 'application/json',
            ])->post($authUrl, [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $supabaseData = $response->json();
                $supabaseApiUser = $supabaseData['user'];

                $request->session()->put('supabase_access_token', $supabaseData['access_token']);
                $request->session()->put('supabase_refresh_token', $supabaseData['refresh_token'] ?? null);
                $request->session()->put('supabase_token_expires_at', now()->addSeconds($supabaseData['expires_in']));

                $localUser = User::updateOrCreate(
                    ['supabase_id' => $supabaseApiUser['id']],
                    [
                        'email' => $supabaseApiUser['email'],
                        'name' => $supabaseApiUser['user_metadata']['full_name'] ?? 'User',
                        'password' => bcrypt(Str::random(16)),
                        'supabase_id' => $supabaseApiUser['id'],
                    ]
                );

                Auth::login($localUser);
                $request->session()->regenerate();

                Log::info('LOGIN_SUCCESS for email: ' . $localUser->email);

                return redirect()->intended(route('dashboard'))->with('success', 'Successfully Logged in!');
            } else {
                $error = $response->json()['error_description'] ?? 'Invalid credentials.';
                Log::warning('Supabase login failed: ' . $error);
                return redirect()->back()->with('error', $error)->withInput();
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Supabase connection error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Authentication service unavailable.')->withInput();
        } catch (\Exception $e) {
            Log::error('General login error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unexpected error during login.')->withInput();
        }
    }

    public function redirectToProvider(string $provider)
    {
        $supabaseUrl = config('services.supabase.url');
        $redirectUrl = route('login.provider.callback', $provider);

        $codeVerifier = Str::random(64);
        session(['code_verifier' => $codeVerifier]);

        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');

        $queryParams = http_build_query([
            'provider' => $provider,
            'redirect_to' => $redirectUrl,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
            'prompt' => 'select_account', // Force account picker
        ]);

        $url = "{$supabaseUrl}/auth/v1/authorize?{$queryParams}";

        return redirect()->away($url);
    }

public function handleProviderCallback(Request $request, string $provider)
{
    $code = $request->query('code');
    $error = $request->query('error');
    $errorDescription = $request->query('error_description');

    // Check for OAuth errors first
    if ($error) {
        Log::error('OAuth error: ' . $error . ' - ' . $errorDescription);
        return redirect()->route('login')->with('error', 'Google authentication failed: ' . ($errorDescription ?? $error));
    }

    if (!$code) {
        Log::error('No authorization code received from Google');
        return redirect()->route('login')->with('error', 'No authorization code received from Google.');
    }

    $codeVerifier = session('code_verifier');
    if (!$codeVerifier) {
        Log::error('No code verifier found in session');
        return redirect()->route('login')->with('error', 'Session expired. Please try again.');
    }

    Log::info('Callback received. Code: ' . $code);
    Log::info('Code Verifier: ' . $codeVerifier);

    $supabaseUrl = config('services.supabase.url');
    $supabaseKey = config('services.supabase.anon_key');

    // Method 1: Try the standard OAuth2 flow
    $postData = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'code_verifier' => $codeVerifier,
        'redirect_uri' => route('login.provider.callback', $provider),
    ];

    Log::info('Attempting token exchange with payload:', $postData);

    $response = Http::asForm()->withHeaders([
        'apikey' => $supabaseKey,
        'Authorization' => 'Bearer ' . $supabaseKey,
        'Content-Type' => 'application/x-www-form-urlencoded',
    ])->post("{$supabaseUrl}/auth/v1/token", $postData);

    Log::info('Token exchange response status: ' . $response->status());
    Log::info('Token exchange response body: ' . $response->body());

    // If Method 1 fails, try Method 2: Direct session exchange
    if ($response->failed()) {
        Log::info('Standard token exchange failed, trying session exchange...');

        $sessionData = [
            'auth_code' => $code,
            'code_verifier' => $codeVerifier,
        ];

        $sessionResponse = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Content-Type' => 'application/json',
        ])->post("{$supabaseUrl}/auth/v1/token?grant_type=pkce", $sessionData);

        Log::info('Session exchange response status: ' . $sessionResponse->status());
        Log::info('Session exchange response body: ' . $sessionResponse->body());

        if ($sessionResponse->successful()) {
            $response = $sessionResponse;
        } else {
            // If both methods fail, try Method 3: Manual verification
            Log::info('Both token exchanges failed, trying manual verification...');

            $verifyResponse = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Content-Type' => 'application/json',
            ])->post("{$supabaseUrl}/auth/v1/verify", [
                'type' => 'pkce',
                'token' => $code,
                'code_verifier' => $codeVerifier,
                'redirect_to' => route('login.provider.callback', $provider),
            ]);

            Log::info('Manual verification response status: ' . $verifyResponse->status());
            Log::info('Manual verification response body: ' . $verifyResponse->body());

            if ($verifyResponse->successful()) {
                $response = $verifyResponse;
            } else {
                Log::error('All token exchange methods failed');
                return redirect()->route('login')->with('error', 'Failed to verify Google authentication. Please try again.');
            }
        }
    }

    $supabaseSession = $response->json();
    Log::info('Final Supabase session data: ', $supabaseSession);

    if (!isset($supabaseSession['user'])) {
        Log::error('User info not returned from Supabase', ['response' => $supabaseSession]);
        return redirect()->route('login')->with('error', 'User information not received from Google.');
    }

    $supabaseUser = $supabaseSession['user'];

    // Store Supabase tokens in session
    if (isset($supabaseSession['access_token'])) {
        $request->session()->put('supabase_access_token', $supabaseSession['access_token']);
        $request->session()->put('supabase_refresh_token', $supabaseSession['refresh_token'] ?? null);
        $request->session()->put('supabase_token_expires_at', now()->addSeconds($supabaseSession['expires_in'] ?? 3600));
    }

    // Log user details
    Log::info('Supabase user ID: ' . $supabaseUser['id']);
    Log::info('Supabase user email: ' . ($supabaseUser['email'] ?? 'No email'));
    Log::info('User metadata: ', $supabaseUser['user_metadata'] ?? []);

    // Create or update local user
    $user = User::updateOrCreate(
        ['supabase_id' => $supabaseUser['id']],
        [
            'email' => $supabaseUser['email'],
            'name' => $supabaseUser['user_metadata']['full_name'] ??
                     $supabaseUser['user_metadata']['name'] ??
                     explode('@', $supabaseUser['email'])[0] ??
                     'Google User',
            'supabase_id' => $supabaseUser['id'],
            'password' => bcrypt(Str::random(16)),
        ]
    );

    Auth::login($user);
    $request->session()->regenerate();
    session()->forget('code_verifier');

    Log::info('Google OAuth login successful for user: ' . $user->email);

    return redirect()->route('dashboard')->with('success', 'Successfully logged in with Google!');
}


    public function logout(Request $request)
    {
        $supabaseUrl = config('services.supabase.url');
        $supabaseAnonKey = config('services.supabase.anon_key');
        $accessToken = $request->session()->get('supabase_access_token');

        if ($supabaseUrl && $supabaseAnonKey && $accessToken) {
            try {
                Http::withHeaders([
                    'apikey' => $supabaseAnonKey,
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($supabaseUrl . '/auth/v1/logout');
            } catch (\Exception $e) {
                Log::error('Supabase logout failed: ' . $e->getMessage());
            }
        }

        Auth::logout();

        $request->session()->forget([
            'supabase_access_token',
            'supabase_refresh_token',
            'supabase_token_expires_at',
            'supabase_user'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Successfully logged out.');
    }
}
