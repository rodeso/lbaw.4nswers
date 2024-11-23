<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditPasswordController extends Controller
{
    // Show the password edit form
    public function edit()
    {
        $user = Auth::user(); // Get the logged-in user
        return view('edit-password-profile', compact('user'));
    }

    // Update the user's password
    public function update(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'email' => 'required|email', // Email
            'password' => 'required|string', // Old password
            'new_password' => 'required|string|min:8|confirmed', // New password and confirmation
        ]);

        $user = Auth::user(); // Get the logged-in user

        //For Debugging
        if ($user) {
            \Log::info('Stored Password Hash: ' . $user->password);
            \Log::info('Entered Password: ' . $request->password);
        }

        // Validate the provided email matches the logged-in user's email
        if ($request->email !== $user->email) {
            return back()->withErrors(['email' => 'The provided email does not match our records.'])->withInput();
        }

        // Check if the old password is correct
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The old password is incorrect.'])->withInput();
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect with success message
        return redirect()->route('edit-profile.edit')->with('success', 'Password updated successfully!');
    }
}
