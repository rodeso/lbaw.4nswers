<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Question;
use App\Models\Tag;
use App\Models\UserFollowsTag;


class ForYouController extends Controller
{
    public function index()
    {

        $notifications = Controller::getNotifications();

        $user = Auth::user(); // Get logged-in user
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

        return view('foryou', compact('user', 'questions', 'tags', 'user_tags', 'notifications'));
    }
}
