<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    // Show the profile edit form
    public function edit()
    {
        $user = Auth::user(); // Get logged-in user
        return view('edit-profile', compact('user'));
    }

    // Update the user's profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update the user's information
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->nickname = $request->input('nickname');

        if($request->filled('birth_date')){
            // Check age
            $birthDate = $request->birth_date;
            $age = \Carbon\Carbon::parse($birthDate)->age;
            if ($age < 13) {
                return back()->withErrors(['birth_date' => 'Sorry, you are too young to create an account.'])->withInput();
            }
            $user->birth_date = $request->input('birth_date');
        }

        // Handle avatar upload if provided
        if ($request->hasFile('avatar')) {
            // Delete the old avatar if exists
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Store the new avatar and update the user's profile
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        // Redirect back to the edit page with a success message
        return redirect()->route('edit-profile.edit')->with('success', 'Profile updated successfully!');
    }
}
