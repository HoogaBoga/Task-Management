<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    /**
     * Show the change password form.
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle the change password request.
     */
    public function changePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'old_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'new_password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        // Check if new password is different from old password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'New password must be different from the old password.']);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Optionally, you can log out all other sessions
        // Auth::logoutOtherDevices($request->new_password);

        return redirect()->back()->with('success', 'Password changed successfully!');
    }
}
