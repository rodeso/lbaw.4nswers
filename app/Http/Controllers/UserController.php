<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Models\AuraVote;

class UserController extends Controller
{
    // Show the user's profile
    public function index()
    {

        $notifications = Controller::getNotifications();

        if(!Auth::check()) {
            return redirect()->route('login')->with('alert', 'You need to be logged in to view your profile.');
        }
        $user = Auth::user();
        $userId = Auth::id(); // Get the logged-in user's ID

        // Fetch user's questions with associated tags and post details
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

        // Fetch user's answers with vote counts
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

        // Calculate the vote difference for each answer
        foreach ($answers as $answer) {
            $answer->vote_difference = $answer->positive_votes - $answer->negative_votes;
        }

        // Fetch user's comments with associated posts
        $comments = Comment::with(['post', 'answer.question']) // Include related post and question
            ->where('author_id', $userId) // Filter comments by user ID
            ->get();

        $tags = Tag::all();

        // Fetch user's followed questions
        $followedQuestions = Question::with(['tags', 'post'])
            ->withCount([
                'popularityVotes as positive_votes' => function ($query) {
                    $query->where('is_positive', true);
                },
                'popularityVotes as negative_votes' => function ($query) {
                    $query->where('is_positive', false);
                },
            ])
            ->join('user_follows_question', 'question.id', '=', 'user_follows_question.question_id')
            ->where('user_follows_question.user_id', $userId) // Filter by the requested user's ID
            ->get();

        // Return data to the profile view
        return view('profile', compact('user', 'questions', 'tags', 'answers', 'comments', 'notifications', 'followedQuestions'));
    }

    // Other profiles
    public function show($id)
    {   

        $notifications = Controller::getNotifications();

        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('home')->with('alert', 'Invalid user ID.');
        }
    
        // Fetch user by ID
        $user = User::find($id); // Returns 404 if user not found
    
        if (!$user) {
            return redirect()->route('home')->with('alert', 'User not found.');
        }
    
        // Fetch user's questions
        $questions = Question::with(['tags', 'post'])
            ->withCount([
                'popularityVotes as positive_votes' => function ($query) {
                    $query->where('is_positive', true);
                },
                'popularityVotes as negative_votes' => function ($query) {
                    $query->where('is_positive', false);
                },
            ])
            ->where('author_id', $id) // Filter by the requested user's ID
            ->get();
    
        // Calculate the vote difference for each question
        foreach ($questions as $question) {
            $question->vote_difference = $question->positive_votes - $question->negative_votes;
        }
    
        // Fetch user's answers
        $answers = Answer::withCount([
            'auraVote as positive_votes' => function ($query) {
                $query->where('is_positive', true);
            },
            'auraVote as negative_votes' => function ($query) {
                $query->where('is_positive', false);
            },
        ])
            ->where('author_id', $id) // Filter answers by user ID
            ->get();
    
        // Calculate the vote difference for each answer
        foreach ($answers as $answer) {
            $answer->vote_difference = $answer->positive_votes - $answer->negative_votes;
        }
    
        // Fetch user's comments
        $comments = Comment::with(['post', 'answer.question'])
            ->where('author_id', $id) // Filter comments by user ID
            ->get();
    
        // Fetch all tags (if needed for the view)
        $tags = Tag::all();

        // Fetch user's followed questions
        $followedQuestions = Question::with(['tags', 'post'])
            ->withCount([
                'popularityVotes as positive_votes' => function ($query) {
                    $query->where('is_positive', true);
                },
                'popularityVotes as negative_votes' => function ($query) {
                    $query->where('is_positive', false);
                },
            ])
            ->join('user_follows_question', 'question.id', '=', 'user_follows_question.question_id')
            ->where('user_follows_question.user_id', $id) // Filter by the requested user's ID
            ->get();
            

    
        // Return the profile view with user data
        return view('profile', compact('user', 'questions', 'tags', 'answers', 'comments', 'notifications', 'followedQuestions'));
    }
    

    // Show the profile edit form
    public function edit()
    {
        $user = Auth::user();

        $notifications = Controller::getNotifications();

        return view('edit-profile', compact('user','notifications'));
    }

    // Show the password edit form
    public function editpassword()
    {
        $user = Auth::user();

        $notifications = Controller::getNotifications();

        return view('edit-password-profile', compact('user','notifications'));
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

    public function toggleMod($id)
    {
        // Ensure the authenticated user has permission to perform this action - is mod
        $this->authorize('moderator');

        $user = User::findOrFail($id);

        // Toggle the mod status
        $user->is_mod = !$user->is_mod;
        $user->save();

        return redirect()->back();
    }

    public function toggleBlock($id)
    { 
        // Ensure the authenticated user has permission to perform this action - is mod
        $this->authorize('moderator');

        $user = User::findOrFail($id);

        // Toggle the block status
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return redirect()->back();
    }

    public function deleteUser($id) 
    {
        $user = User::findOrFail($id); // User that will be deleted

        // Ensure the authenticated user has permission to perform this action - is the user or is mod
        $this->authorize('delete-user', $user);   

        $user->delete();

        if (Auth::id() === $user->id) {
            Auth::logout();
        }
        
        return redirect()->route('home')->with('success', 'The user has been deleted successfully.');
    }

    public function create()
    {
        $notifications = Controller::getNotifications();
        return view('create-user', compact('notifications'));
    }
    
    public function store(Request $request)
    {
        $notifications = Controller::getNotifications();

        // Validate incoming data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:user',
            'email' => 'required|email|unique:user',
            'password' => 'required|string|min:8|confirmed',
            'birth_date' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_mod' => 'nullable|boolean',
            'is_blocked' => 'nullable|boolean',
            'aura' => 'nullable|integer',
            'is_admin' => 'nullable|boolean',
        ]);

        // Check for age requirement
        $birthDate = $data['birth_date'] ?? null;
        if ($birthDate) {
            $age = \Carbon\Carbon::parse($birthDate)->age;
            if ($age < 13) {
                return back()->withErrors(['birth_date' => 'Sorry, you are too young to create an account.'])->withInput();
            }
        }

        // Create new user
        $user = new User();
        $user->name = $data['name'];
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->birth_date = $data['birth_date'];
        $user->aura = $data['aura'] ?? 0;
        $user->is_mod = ($data['is_mod'] ?? false) || ($data['is_admin'] ?? false);
        $user->is_blocked = $data['is_blocked'] ?? false;

        // Save user
        $user->save();

        // Handle admin creation
        if ($data['is_admin'] ?? false) {
            DB::table('admin')->insert([
                'id' => $user->id,
                'admin_start' => now(),
            ]);
        }

        return redirect()->route('admin-dashboard.users')->with('success', 'User created successfully!');

    }
}