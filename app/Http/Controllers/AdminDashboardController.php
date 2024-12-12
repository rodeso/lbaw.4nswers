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
    public function index()
    {   

        $loggedUserId = auth()->id(); // Get the logged-in user ID
        // Fetch notifications where the user is the owner of the related post
        $notifications = DB::table('vote_notification')
            ->join('notification', 'vote_notification.notification_id', '=', 'notification.id')
            ->join('post', 'notification.post_id', '=', 'post.id')
            ->leftJoin('question', 'post.id', '=', 'question.post_id')
            ->leftJoin('answer', 'post.id', '=', 'answer.post_id')
            ->where(function ($query) use ($loggedUserId) {
                $query->where('question.author_id', $loggedUserId)
                    ->orWhere('answer.author_id', $loggedUserId);
            })
            ->select('notification.id', 'notification.content', 'notification.time_stamp', 'question.id as question_id', 'answer.question_id as answer_question_id', 'question.title as question_title', 'post.body as answer_body')
            ->orderBy('notification.time_stamp', 'desc')
            ->get();

        $user = Auth::user(); // Get logged-in user
        $users = User::orderBy('aura', 'desc')->get();
        $questions = Question::with(['tags', 'post'])->get();
        $tags = Tag::all();
        $user_tags = $user 
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', $user->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if $user is null

        return view('admin-dashboard', compact('user', 'users', 'questions', 'tags', 'user_tags', 'notifications'));
    }
}
