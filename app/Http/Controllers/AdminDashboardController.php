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
    public function users() {   
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

    public function tags() {   
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

    public function posts() {   
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
    
        // Fetch all reported questions
        $questions = DB::table('question')
            ->join('post', 'question.post_id', '=', 'post.id')
            ->join('notification', 'post.id', '=', 'notification.post_id')
            ->join('report_notification', 'notification.id', '=', 'report_notification.notification_id')
            ->select(
                'question.*',
                'post.body as post_body',
                DB::raw('COUNT(report_notification.notification_id) as report_count')
            )
            ->groupBy('question.id', 'post.id') // Ensure proper grouping for aggregation
            ->orderByDesc('report_count') // Order by the number of reports
            ->get();
    
        // Fetch all reported answers
        $answers = DB::table('answer')
            ->join('post', 'answer.post_id', '=', 'post.id')
            ->join('notification', 'post.id', '=', 'notification.post_id')
            ->join('report_notification', 'notification.id', '=', 'report_notification.notification_id')
            ->select(
                'answer.*',
                'post.body as post_body',
                DB::raw('COUNT(report_notification.notification_id) as report_count')
            )
            ->groupBy('answer.id', 'post.id') // Ensure proper grouping for aggregation
            ->orderByDesc('report_count') // Order by the number of reports
            ->get();
    
        // Fetch all reported comments
        $comments = DB::table('comment')
            ->join('post', 'comment.post_id', '=', 'post.id')
            ->join('notification', 'post.id', '=', 'notification.post_id')
            ->join('report_notification', 'notification.id', '=', 'report_notification.notification_id')
            ->select(
                'comment.*',
                'post.body as post_body',
                DB::raw('COUNT(report_notification.notification_id) as report_count')
            )
            ->groupBy('comment.id', 'post.id') // Ensure proper grouping for aggregation
            ->orderByDesc('report_count') // Order by the number of reports
            ->get();
    
        // Fetch all users for the dashboard
        $users = User::orderBy('aura', 'desc')->get();
    
        return view('admin-dashboard-posts', compact('user', 'users', 'questions', 'answers', 'comments', 'notifications'));
    }
    
    public function deleteTag($id) {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->back();
    }
}
