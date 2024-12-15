<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Question;
use App\Models\Tag;
use App\Models\UserFollowsTag;
use App\Models\User;


class AdminDashboardController extends Controller
{
    public function users()
    {   
        if (!Auth::check()) {
            // Redirect to home with an alert
            return redirect()->route('home')->with('alert', 'You are not logged in!');
        }
        $user = Auth::user(); // Get logged-in user
        if (!$user->is_admin && !$user->is_mod) {
            // Redirect to home with an alert
            return redirect()->route('home')->with('alert', 'You do not have the right permissions!');
        }

        $notifications = Controller::getNotifications();
        
        $users = User::orderBy('aura', 'desc')->get();
        return view('admin-dashboard-users', compact('user', 'users', 'notifications'));
    }

    public function tags()
    {   
        if (!Auth::check()) {
            // Redirect to home with an alert
            return redirect()->route('home')->with('alert', 'You are not logged in!');
        }
        $user = Auth::user(); // Get logged-in user
        if (!$user->is_admin && !$user->is_mod) {
            // Redirect to home with an alert
            return redirect()->route('home')->with('alert', 'You do not have the right permissions!');
        }
        
        $notifications = Controller::getNotifications();

        $users = User::orderBy('aura', 'desc')->get();
        $tags = Tag::orderBy('follower_count', 'desc')->get();
        return view('admin-dashboard-tags', compact('user', 'users', 'tags', 'notifications'));
    }

    public function deleteTag($id)
{
    $tag = Tag::findOrFail($id);
    $tag->delete();

    return redirect()->back();
}

}
