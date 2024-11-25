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
        return view('index', compact('user','questions', 'tags', 'user_tags'));
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

}

