<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\Question;
use App\Models\Answer;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;

class TagPageController extends Controller
{
    public function index($id)
    {   

        $loggedUserId = auth()->id(); // Get the logged-in user ID
        $user = User::find($loggedUserId); // Get the logged-in user
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

        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('home')->with('alert', 'Invalid user ID.');
        }
    
        // Fetch tag by ID
        $tag = Tag::find($id); // Returns 404 if user not found
    
        if (!$tag) {
            return redirect()->route('home')->with('alert', 'Tag not found.');
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
            ->whereHas('tags', function ($query) use ($id) {
                $query->where('tag_id', $id); // Filter questions that have the selected tag
            })
            ->get();
            
        $questions = $questions->sortByDesc(function ($question) {
            return $question->positive_votes - $question->negative_votes; // Sorting by vote difference
        });

        // Calculate the vote difference for each question
        foreach ($questions as $question) {
            $question->vote_difference = $question->positive_votes - $question->negative_votes;
        }
    
        // Fetch all tags (if needed for the view)
        $tags = Tag::all();

    
        // Return the profile view with user data
        return view('tag-page', compact('user', 'questions', 'tags', 'tag', 'notifications'));
    }

}
