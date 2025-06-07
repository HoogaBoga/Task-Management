<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Make sure your User model is in this path
use Illuminate\Support\Facades\Hash; // <-- Import Hash

class UserController extends Controller
{
    /**
     * Update the user's profile information (name and description).
     */
    public function updateProfile(Request $request)
    {
        // 1. Get the currently authenticated user's ID
        $authUserId = Auth::id();
        if (!$authUserId) {
            return back()->with('error', 'You must be logged in to update your profile.');
        }

        // 2. Validate the incoming data from the form
        $request->validate([
            'username' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // 3. Update the user's details in your local database
        try {
            // THE FIX: Find the actual Eloquent model from your database first
            $userToUpdate = User::find($authUserId);
            if (!$userToUpdate) {
                 return back()->with('error', 'User record not found in the database.');
            }

            $userToUpdate->name = $request->username;
            $userToUpdate->description = $request->description;
            $userToUpdate->save(); // Now this will work correctly

            Log::info('User profile updated successfully for user ID: ' . $userToUpdate->id);

        } catch (\Exception $e) {
            Log::error('Error updating user profile: ' . $e->getMessage());
            return back()->with('error', 'Failed to update profile details.');
        }

        // 4. Redirect back with a success message
        return redirect()->route('user.profile')->with('success', 'Profile details updated successfully!');
    }

    /**
     * Update the user's profile picture using Supabase Storage.
     */
    public function updateAvatar(Request $request)
    {
        Log::info('UserController@updateAvatar called');

        // 1. Get the authenticated user object (we still need it for the UUID)
        $user = Auth::user();
        if (!$user) {
            Log::warning('User not logged in when trying to update avatar');
            return back()->with('error', 'You must be logged in to update your avatar.');
        }

        // 2. Validate the uploaded file
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $file = $request->file('avatar');

        Log::info('Avatar image uploaded with original name: ' . $file->getClientOriginalName());

        // 3. Prepare for Supabase upload
        $bucket = env('SUPABASE_BUCKET_AVATARS', 'avatars');
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_SERVICE_ROLE');
        $fileName = 'public/' . $user->uuid . '.' . $file->getClientOriginalExtension();

        try {
            // 4. Perform the HTTP request to upload the file
            $uploadResponse = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
            ])->attach(
                'file', file_get_contents($file), $fileName, [
                    'Content-Type' => $file->getMimeType(),
                ]
            )->post("$supabaseUrl/storage/v1/object/$bucket/$fileName", [
                'cacheControl' => '3600',
                'upsert' => 'true',
            ]);

            if ($uploadResponse->failed()) {
                Log::error('Failed to upload avatar to Supabase.', [
                    'status' => $uploadResponse->status(),
                    'response' => $uploadResponse->body(),
                ]);
                return back()->with('error', 'Failed to upload avatar.');
            }

            // 5. Construct the public URL
            $imageUrl = "$supabaseUrl/storage/v1/object/public/$bucket/$fileName";
            Log::info('Avatar uploaded successfully for user ID ' . $user->id . '. Public URL: ' . $imageUrl);

            // 6. Save the new avatar URL to your local User model
            // THE FIX: Find the actual Eloquent model from your database first
            $userToUpdate = User::find($user->id);
            if (!$userToUpdate) {
                return back()->with('error', 'User record not found in the database.');
            }

            $userToUpdate->avatar_url = $imageUrl . '?t=' . time(); // Add a timestamp to break browser cache
            $userToUpdate->save(); // Now this will work correctly

        } catch (\Exception $e) {
            Log::error('Exception while uploading avatar', ['message' => $e->getMessage()]);
            return back()->with('error', 'Error uploading avatar.');
        }

        // 7. Redirect back with a success message
        return redirect()->route('user.profile')->with('success', 'Profile picture updated successfully!');
    }

    public function deleteAccount(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return back()->with('error', 'User not authenticated');
    }

    $hasPassword = !empty($user->password);

    if ($hasPassword) {
        $request->validate(['password' => 'required|string']);

        // Use the correct Supabase authentication endpoint
        $supabaseUrl = config('services.supabase.url');
        $supabaseAnonKey = config('services.supabase.anon_key');
        $supabaseServiceRole = config('services.supabase.service_role_key');
        $bucket = config('services.supabase.bucket_avatars', 'avatars');

    // Add debugging
        Log::info('Supabase Config Check:', [
            'url' => $supabaseUrl ? 'SET' : 'NOT SET',
            'service_role_key' => $supabaseServiceRole ? 'SET' : 'NOT SET',
            'bucket' => $bucket
        ]);

        if (!$supabaseUrl || !$supabaseAnonKey) {
            Log::error('Supabase credentials missing for password verification.');
            return back()->with('error', 'Authentication service is misconfigured.');
        }

        // Use the correct endpoint for password verification
        $authUrl = $supabaseUrl . '/auth/v1/token?grant_type=password';

        try {
            $response = Http::withHeaders([
                'apikey' => $supabaseAnonKey,
                'Content-Type' => 'application/json',
            ])->post($authUrl, [
                'email' => $user->email,
                'password' => $request->password,
            ]);

            Log::info('Password verification response status: ' . $response->status());
            Log::info('Password verification response body: ' . $response->body());

            if ($response->failed()) {
                $error = $response->json()['error_description'] ?? 'The provided password does not match our records.';
                Log::warning('Password verification failed: ' . $error);
                return back()->with('error', $error);
            }

            Log::info('Password verification successful for user: ' . $user->email);

        } catch (\Exception $e) {
            Log::error('Password verification error: ' . $e->getMessage());
            return back()->with('error', 'Unable to verify password. Please try again.');
        }

    } else {
        // This part for Google/OAuth users remains the same
        $request->validate(['confirmation' => 'required|string']);
        if ($request->confirmation !== $user->email) {
            return back()->with('error', 'The text you entered did not match your email address.');
        }
    }

    $supabaseUrl = config('services.supabase.url');
    $supabaseServiceRole = config('services.supabase.service_role_key');
    $bucket = config('services.supabase.bucket_avatars', 'avatars');

    if (!$supabaseUrl || !$supabaseServiceRole) {
        Log::error('Supabase URL or Service Role Key is not configured.');
        return back()->with('error', 'Server configuration error. Could not process deletion.');
    }

    try {
        // Delete avatar files if they exist
        if ($user->avatar_url) {
            $searchPrefix = 'public/' . $user->supabase_id; // Use supabase_id instead of uuid

            $listResponse = Http::withHeaders([
                'apikey' => $supabaseServiceRole,
                'Authorization' => 'Bearer ' . $supabaseServiceRole
            ])->post("$supabaseUrl/storage/v1/object/$bucket/list", [
                'prefix' => $searchPrefix,
                'limit' => 10
            ]);

            if ($listResponse->successful() && !empty($listResponse->json())) {
                $filesToDelete = $listResponse->json();
                $fileNames = array_map(function ($file) {
                    return $file['name'];
                }, $filesToDelete);

                Http::withHeaders([
                    'apikey' => $supabaseServiceRole,
                    'Authorization' => 'Bearer ' . $supabaseServiceRole
                ])->delete("$supabaseUrl/storage/v1/object/$bucket", [
                    'prefixes' => $fileNames
                ]);
                Log::info('Successfully deleted avatar(s) for user ID: ' . $user->id, ['files' => $fileNames]);
            }
        }

        // Delete user from Supabase Auth
        $authDeleteResponse = Http::withHeaders([
            'apikey' => $supabaseServiceRole,
            'Authorization' => 'Bearer ' . $supabaseServiceRole
        ])->delete("$supabaseUrl/auth/v1/admin/users/{$user->supabase_id}"); // Use supabase_id

        if ($authDeleteResponse->failed()) {
            Log::error('Failed to delete user from Supabase Auth.', [
                'status' => $authDeleteResponse->status(),
                'response' => $authDeleteResponse->body(),
                'user_supabase_id' => $user->supabase_id
            ]);
            return back()->with('error', 'Failed to delete account from the authentication server.');
        }

        Log::info('Successfully deleted user from Supabase Auth for user ID: ' . $user->id);

        // Log the user out and delete from local database
        $userIdToDelete = $user->id;

        // Log the user out of the session
        Auth::logout();

        // Find and delete the user from local database
        $userToDelete = User::find($userIdToDelete);
        if ($userToDelete) {
            $userToDelete->delete();
            Log::info('Successfully deleted user from local database. User ID: ' . $userIdToDelete);
        }

        // Clear session data
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect with success message
        session()->flash('success', 'Your account has been permanently deleted.');
        return redirect()->route('login');

    } catch (\Exception $e) {
        Log::error('An Exception occurred during account deletion for user ID: ' . $user->id . ' - ' . $e->getMessage());
        return back()->with('error', 'An unexpected error occurred. Please contact support.');
    }
}
}
