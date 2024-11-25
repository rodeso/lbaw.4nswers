<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Tag;

class UserController extends Controller
{
    // Show the user's profile
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::id(); // Get the logged-in user's ID
        $questions = Question::with(['tags', 'post'])
        ->withCount([
            'popularityVotes as positive_votes' => function ($query) {
                $query->where('is_positive', true);
            },
            'popularityVotes as negative_votes' => function ($query) {
                $query->where('is_positive', false);
            },
        ])
        ->where('author_id', $userId) // Filter questions by user ID
        ->get();

        // Calculate the vote difference for each question
        foreach ($questions as $question) {
            $question->vote_difference = $question->positive_votes - $question->negative_votes;
        }
        $tags = Tag::all();
        $answers = Answer::withCount([
            'auraVote as positive_votes' => function ($query) {
                $query->where('is_positive', true);
            },
            'auraVote as negative_votes' => function ($query) {
                $query->where('is_positive', false);
            },
        ])
        ->where('author_id', $userId) // Filter answers by user ID
        ->get();

        // Calculate the vote difference for each question
        foreach ($answers as $answer) {
            $answer->vote_difference = $answer->positive_votes - $answer->negative_votes;
        }
        
         // Filter answer by user ID 
        return view('profile', compact('user','questions', 'tags','answers'));
    }

    // Show the profile edit form
    public function edit()
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    // Show the password edit form
    public function editpassword()
    {
        $user = Auth::user();
        return view('edit-password-profile', compact('user'));
    }

    // Update the user's profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:user,nickname,' . Auth::id(),
            'birth_date' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update the user's name and nickname
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->nickname = $request->input('nickname');
        

        if($request->filled('birth_date')){ // Update birth date if provided
            $birthDate = $request->birth_date;
            $age = \Carbon\Carbon::parse($birthDate)->age;
            if ($age < 13) {
                return back()->withErrors(['birth_date' => 'Sorry, you are too young to create an account.'])->withInput();
            }
            $user->birth_date = $request->input('birth_date');
        }

        // Update photo if provided
        if ($request->hasFile('profile_picture')) {
            // Delete the old avatar if exists
            if ($user->profile_picture && $user->profile_picture !== 'profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') {
                Storage::delete($user->profile_picture);
            }

            // Store the new avatar and update the user's profile
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
        
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }


    // Update the user's password
    public function updatepassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check the email is correct with the logged in user
        if ($request->email !== $user->email) {
            return back()->withErrors(['email' => 'The provided email does not match our records.'])->withInput();
        }

        // Check if the old password is correct with the logged in user
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The old password is incorrect.'])->withInput();
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }
}
