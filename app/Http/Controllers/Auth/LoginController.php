<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Laravel's Auth Facade
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Your Laravel User model\
use function Illuminate\Support\retry;


class LoginController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $supabaseUrl = config('services.supabase.url');
        $supabaseAnonKey = config('services.supabase.anon_key'); // For public auth actions

        if (!$supabaseUrl || !$supabaseAnonKey) {
            Log::error('Supabase credentials (URL or Anon Key) missing for login.');
            return redirect()->back()->with('error', 'Authentication service is misconfigured. Please contact support.')->withInput();
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
                $supabaseApiUser = $supabaseData['user']; // User object from Supabase

                // Store Supabase-specific session data (optional, but can be useful)
                $request->session()->put('supabase_access_token', $supabaseData['access_token']);
                $request->session()->put('supabase_refresh_token', $supabaseData['refresh_token'] ?? null);
                $request->session()->put('supabase_token_expires_at', now()->addSeconds($supabaseData['expires_in']));

                // --- Integrate with Laravel's Auth System ---
                // Find or create a user in your local 'users' table
                $localUser = User::updateOrCreate(
                    ['supabase_id' => $supabaseApiUser['id']], // Find by Supabase ID
                    [
                        'email' => $supabaseApiUser['email'],
                        'name' => $supabaseApiUser['user_metadata']['full_name'] ?? 'User', // Get name from metadata
                        'password' => bcrypt(str()->random(16)), // Set a random local password, Supabase handles real auth
                    ]
                );

                // Log this user into Laravel's authentication system
                Auth::login($localUser);
                // --- End Laravel Auth Integration ---

                $request->session()->regenerate(); // Regenerate session ID for security

                Log::info('LOGIN_SUCCESS: Supabase & Laravel login complete for email: ' . $localUser->email . ' ID: ' . $localUser->id);

                // Now redirect to the intended page or a default
                return redirect()->intended(route('user'))->with('success', 'Successfully Logged in!');

            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['error_description'] ?? ($errorData['message'] ?? 'Invalid login credentials.');
                Log::warning('Supabase login failed for email: ' . $request->email . ' - Supabase Error: ' . $errorMessage, ['response_body' => $errorData]);
                return redirect()->back()->with('error', $errorMessage)->withInput();
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Supabase connection error during login: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not connect to authentication service. Please try again later.')->withInput();
        } catch (\Exception $e) {
            Log::error('General error during Supabase login: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'An unexpected error occurred during login. Please try again.')->withInput();
        }
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request)
    {
        $supabaseUrl = config('services.supabase.url');
        $supabaseAnonKey = config('services.supabase.anon_key');
        $accessToken = $request->session()->get('supabase_access_token');

        // 1. Tell Supabase to invalidate the token (Best effort)
        if ($supabaseUrl && $supabaseAnonKey && $accessToken) {
            try {
                Http::withHeaders([
                    'apikey' => $supabaseAnonKey,
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($supabaseUrl . '/auth/v1/logout');
            } catch (\Exception $e) {
                Log::error('Supabase logout API error: ' . $e->getMessage());
                // Don't prevent logout if Supabase call fails, just log it.
            }
        }

        // 2. Log out from Laravel's authentication system
        Auth::logout();

        // 3. Clear Supabase-related data from Laravel Session
        $request->session()->forget([
            'supabase_user', // You might still want to keep this if you stored the full object
            'supabase_access_token',
            'supabase_refresh_token',
            'supabase_token_expires_at'
        ]);

        // 4. Invalidate the entire Laravel session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Successfully logged out.'); // Redirect to login or homepage
    }
}
