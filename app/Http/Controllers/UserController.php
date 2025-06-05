<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Make sure your User model is in this path

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
}
