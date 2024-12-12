<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\UserFollowsTag;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $questions = Question::with(['tags', 'post'])
            ->withCount([
                'popularityVotes as positive_votes' => function ($query) {
                    $query->where('is_positive', true);
                },
                'popularityVotes as negative_votes' => function ($query) {
                    $query->where('is_positive', false);
                },
            ])
            ->get();

        // Calculate the vote difference for each question
        foreach ($questions as $question) {
            $question->vote_difference = $question->positive_votes - $question->negative_votes;
        }
        $tags = Tag::all();
        $user_tags = $user 
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', $user->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if $user is null


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


        return view('index', compact('user','questions', 'tags', 'user_tags','notifications'));
    }

        // In UserController or appropriate controller
    public function reorderByPopularity(Request $request)
    {
        $user = Auth::user();
        $userId = Auth::id(); // Get the logged-in user's ID

        // Fetch the questions ordered by popularity votes
        $questions = Question::withCount([
            'popularityVotes as positive_votes' => function ($query) {
                $query->where('is_positive', true);
            },
            'popularityVotes as negative_votes' => function ($query) {
                $query->where('is_positive', false);
            },
        ])
        ->get();
    
        // Calculate the vote difference and reorder the collection
        $questions = $questions->sortByDesc(function ($question) {
            return $question->positive_votes - $question->negative_votes; // Sorting by vote difference
        });
    
        // Calculate the vote difference for each question
        foreach ($questions as $question) {
            $question->vote_difference = $question->positive_votes - $question->negative_votes;
        }

        $tags = Tag::all();
        $user_tags = $user 
        ? Tag::whereIn('id', UserFollowsTag::where('user_id', $user->id)->pluck('tag_id'))->get()
        : collect(); // Return an empty collection if $user is null
        return view('index', compact('user','questions', 'tags', 'user_tags'));
    }

    public function reorderByUrgent(Request $request)
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
        ->orderBy('time_end', 'asc') // Sort by time_end in ascending order (earliest deadlines first)
        ->where('time_end', '>', now())
        ->get();

        // Optionally calculate the time difference (urgency) for display
        foreach ($questions as $question) {
            $question->time_remaining = now()->diffInSeconds($question->time_end, false); // Negative if expired
        }

        foreach ($questions as $question) {
            $question->vote_difference = $question->positive_votes - $question->negative_votes;
        }

        $tags = Tag::all();
        $user_tags = $user 
        ? Tag::whereIn('id', UserFollowsTag::where('user_id', $user->id)->pluck('tag_id'))->get()
        : collect(); // Return an empty collection if $user is null
        return view('index', compact('user','questions', 'tags', 'user_tags'));
    }

    public function reorderByNew(Request $request)
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
            ->join('post', 'post.id', '=', 'question.post_id')
            ->orderBy('post.time_stamp', 'desc') // Sort by the post's timestamp in descending order
            ->get();

        // Optionally calculate the time difference (urgency) for display
        foreach ($questions as $question) {
            $question->time_remaining = now()->diffInSeconds($question->time_end, false); // Negative if expired
        }
        foreach ($questions as $question) {
            $question->vote_difference = $question->positive_votes - $question->negative_votes;
        }

        $tags = Tag::all();
        $user_tags = $user 
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', $user->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if $user is null

        return view('index', compact('user', 'questions', 'tags', 'user_tags'));
    }

}

