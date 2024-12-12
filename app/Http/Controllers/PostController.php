<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Post;
use App\Models\Tag;
use App\Models\UserFollowsTag;
use App\Models\PopularityVote;
use App\Models\AuraVote;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show($id)
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

        if (!is_numeric($id)) {
            return redirect()->route('home')->with('alert', 'Invalid question ID.');
        }
        
        $question = Question::with([
            'post',
            'tags',
            'author',
            'answers.post',
            'answers.author',
            'answers.post.moderatorNotifications',
            'answers.comments' => function ($query) {
                $query->with(['post', 'author']);  // This is fine since comment has an author and post
            }
        ])
        ->find($id);

        // If the question does not exist, redirect to home with a message
        if (!$question) {
            return redirect()->route('home')->with('alert', 'Question not found.');
        }

        // Calculate aura for each answer
        foreach ($question->answers as $answer) {
            $answer->aura = AuraVote::where('answer_id', $answer->id)
                ->where('is_positive', true)
                ->count() 
                - AuraVote::where('answer_id', $answer->id)
                ->where('is_positive', false)
                ->count();
        }
    
        // Tags that user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect();
    
        // Get the user's vote (if they have voted)
        $userVote = null;
        if (auth()->check()) {
            $userVote = PopularityVote::where('user_id', auth()->id())
                ->where('question_id', $id)
                ->value('is_positive');
        }
    
        // Pass data to view
        return view('post', compact('question', 'user_tags', 'userVote', 'notifications'));
    }
    
    /*
    Store -------------------------------------------------------------------------------------------------------------------------
    */

    public function storeQuestion(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:4096',
            'urgency' => 'required|string|in:Red,Orange,Yellow,Green',
            'tags' => 'nullable|string', // Comma-separated tag IDs
            'new_tags' => 'nullable|string', // JSON string of new tag objects
        ]);

        // Create the post
        $post = Post::create([
            'body' => $validated['body'],
            'time_stamp' => now(),
        ]);

        // Calculate time_end based on urgency
        $urgencyDurations = ['Red' => 3, 'Orange' => 5, 'Yellow' => 10, 'Green' => 24];
        $timeEnd = now()->addHours($urgencyDurations[$validated['urgency']]);

        // Create the question
        $question = Question::create([
            'title' => $validated['title'],
            'urgency' => $validated['urgency'],
            'author_id' => Auth::id(),
            'post_id' => $post->id,
            'time_end' => $timeEnd,
            'closed' => false,
        ]);

        // Attach selected existing tags
        if (!empty($validated['tags'])) {
            $tagIds = array_filter(explode(',', $validated['tags']), fn($tagId) => !empty($tagId));
            if (!empty($tagIds)) {
                $question->tags()->attach($tagIds);
            }
        }

        // Handle new tags
        if (!empty($validated['new_tags'])) {
            $newTags = json_decode($validated['new_tags'], true);
            $newTagIds = [];
            foreach ($newTags as $newTag) {
                if (!empty($newTag['name']) && !empty($newTag['description'])) {
                    $createdTag = Tag::create([
                        'name' => $newTag['name'],
                        'description' => $newTag['description'],
                    ]);
                    $newTagIds[] = $createdTag->id;
                }
            }

            // Attach new tags
            if (!empty($newTagIds)) {
                $question->tags()->attach($newTagIds);
            }
        }

        return redirect()->route('question.show', $question->id)->with('success', 'Your question has been posted successfully.');
    }

    public function storeAnswer(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:4096',
            'question_id' => 'required|exists:question,id',
        ]);

        // Fetch the question to check if it's closed
        $question = Question::find($validated['question_id']);

        if ($question->closed) {
            // If the question is closed, redirect with an error message
            return redirect()
                ->route('question.show', ['id' => $validated['question_id']])
                ->with('error', 'The question is closed and cannot accept new answers.');
        }

        // Create the post associated with the answer
        $post = Post::create([
            'body' => $request->body,
            'time_stamp' => now(),
        ]);

        // Create the answer with the post_id
        $answer = new Answer([
            'body' => $validated['body'],
            'author_id' => Auth::id(),
            'question_id' => $validated['question_id'],
            'post_id' => $post->id,
        ]);
        
        // Save the answer
        $answer->save();

        // Redirect or return success response
        return redirect()->route('question.show', ['id' => $validated['question_id']]);
    }

    public function storeComment(Request $request, $answerId)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:4096',
        ]);

        $answer = Answer::findOrFail($answerId);

        // Create the post associated with the comment
        $post = Post::create([
            'body' => $validated['body'],
            'time_stamp' => now(),
        ]);

        // Create the comment
        $comment = Comment::create([
            'answer_id' => $answerId,
            'author_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    /*
    Show -------------------------------------------------------------------------------------------------------------------------
    */

    public function showNewQuestion()
    {
        if (!Auth::check()) {
            // Redirect to home with an alert
            return redirect()->route('home')->with('alert', 'You must be logged in to post a new question!');
        }

        // Tags that user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if logged in user is null
        
        // Extract all the tags
        $tags = Tag::all();
    
        // Pass the tags to the view
        return view('new-question', compact('tags', 'user_tags'));
    }

    public function showEditQuestion($id)
    {
        $question = Question::with('tags')->findOrFail($id);

        // Check if the logged-in user is the author of the question 
        if (Auth::id() !== $question->author_id) {
            return redirect()->route('question.show', ['id' => $id]);
        }

        $post = Post::findOrFail($question->post_id);

        // Tags that the user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect();

        // Extract all the tags for selection
        $tags = Tag::all();

        return view('edit-question', compact('tags', 'user_tags', 'question', 'post'));
    }

    public function showEditAnswer($id)
    {
        $answer = Answer::findOrFail($id);

        // Check if the logged-in user is the author of the answer 
        /*if (Auth::id() !== $answer->author_id) {
            return redirect()->route('question.show', ['id' => $id]);
        }*/

        $post = Post::findOrFail($answer->post_id);

        // Tags that the user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect();


        return view('edit-answer', compact('user_tags', 'answer', 'post'));
    }

    /*
    Votes -------------------------------------------------------------------------------------------------------------------------
    */

    public function vote(Request $request, $questionId)
    {
        $userId = auth()->id();
        // Fetch the question to check if it's closed
        $question = Question::find($questionId);

        if ($question->closed) {
            // If the question is closed, redirect with an error message
            return redirect()
                ->route('question.show', ['id' => $questionId])
                ->with('error', 'The question is closed and cannot accept new answers.');
        }
        $voteType = $request->input('vote'); // 'upvote' or 'downvote'
        
        // Check if the user has already voted
        $existingVote = PopularityVote::where('user_id', $userId)
            ->where('question_id', $questionId)
            ->first();
        
        $voteUndone = false; // Initialize flag
        
        if ($existingVote) {
            // If the user clicks the same button twice, remove the vote (undo)
            if (($voteType === 'upvote' && $existingVote->is_positive) ||
                ($voteType === 'downvote' && !$existingVote->is_positive)) {
                $existingVote->delete();
                $voteUndone = true; // Mark that vote was undone

                // Return the updated vote count and voteUndone flag
                $totalVotes = PopularityVote::where('question_id', $questionId)
                    ->where('is_positive', true)->count()
                    - PopularityVote::where('question_id', $questionId)
                    ->where('is_positive', false)->count();
        
                return response()->json(['totalVotes' => $totalVotes, 'voteUndone' => $voteUndone]);
            }

            // Otherwise, update the vote
            $existingVote->is_positive = ($voteType === 'upvote');
            $existingVote->save();
        } else {
            // Create a new vote if none exists
            PopularityVote::create([
                'user_id' => $userId,
                'question_id' => $questionId,
                'is_positive' => ($voteType === 'upvote'),
            ]);
        }

        // Calculate total votes
        $totalVotes = PopularityVote::where('question_id', $questionId)
            ->where('is_positive', true)->count()
            - PopularityVote::where('question_id', $questionId)
            ->where('is_positive', false)->count();
        
        return response()->json(['totalVotes' => $totalVotes, 'voteUndone' => $voteUndone]);
    }

    public function auraVote(Request $request, $answerId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'You must be logged in to vote'], 403);
        }

        // Retrieve the associated answer and its question
        $answer = Answer::find($answerId);

        if (!$answer) {
            return response()->json(['error' => 'Answer not found'], 404);
        }

        $question = $answer->question;

        if ($question->closed) {
            // Calculate the current aura of the answer
            $totalAura = AuraVote::where('answer_id', $answerId)
                ->where('is_positive', true)
                ->count() 
                - AuraVote::where('answer_id', $answerId)
                ->where('is_positive', false)
                ->count();

            return response()->json([
                'error' => 'Voting is not allowed as the question is closed.',
                'totalAura' => $totalAura,
            ], 403);
        }

        $userId = auth()->id();
        $isPositive = $request->input('vote') === 'upvote';

        // Check if the user has already voted on this answer
        $existingVote = AuraVote::where('user_id', $userId)
            ->where('answer_id', $answerId)
            ->first();

        if ($existingVote) {
            if ($existingVote->is_positive === $isPositive) {
                $existingVote->delete(); // Remove the vote
            } else {
                $existingVote->is_positive = $isPositive;
                $existingVote->save(); // Save the updated vote
            }
        } else {
            AuraVote::create([
                'user_id' => $userId,
                'answer_id' => $answerId,
                'is_positive' => $isPositive,
            ]);
        }

        // Calculate the total aura after the vote
        $totalAura = AuraVote::where('answer_id', $answerId)
            ->where('is_positive', true)
            ->count() 
            - AuraVote::where('answer_id', $answerId)
            ->where('is_positive', false)
            ->count();

        return response()->json(['totalAura' => $totalAura]);
    }

    /*
    Update -------------------------------------------------------------------------------------------------------------------------
    */

    public function updateQuestion(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:4096',
            'urgency' => 'required|string|in:Red,Orange,Yellow,Green',
        ]);

        // Retrieve the question
        $question = Question::findOrFail($id);

        $post = Post::findOrFail($question->post_id);
        $post->update([
            'body' => $validated['body'],
        ]);

        // Update the question
        $question->update([
            'title' => $validated['title'],
            'urgency' => $validated['urgency'],
        ]);

        return redirect()->route('question.show', $question->id)->with('success', 'Question updated successfully!');
    }

    public function updateAnswer(Request $request, $id)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:4096',
        ]);

        // Find the answer and update it
        $answer = Answer::findOrFail($id);
        $post = Post::findOrFail($answer->post_id);
        $post->update([
            'body' => $validated['body'],
        ]);

        return redirect()->route('question.show', $answer->question->id)->with('success', 'Answer updated successfully!');
    }
    public function closeQuestion($id)
    {
        // Retrieve the question
        $question = Question::findOrFail($id);

        // Check if the authenticated user is the author or an admin
        if (Auth::id() !== $question->author_id && !Auth::user()->is_mod) {
            return redirect()->route('question.show', $id)->with('error', 'You are not authorized to close this question.');
        }

        // Close the question
        $question->closed = true;
        $question->save();

        return redirect()->route('question.show', $id)->with('success', 'Question closed successfully!');
    }

    public function chooseAnswer(Request $request, $questionId, $answerId)
    {
        // Find the question using the passed questionId
        $question = Question::find($questionId);
        
        // Find the answer using the passed answerId
        $answer = Answer::find($answerId);

        // Check if question or answer exists
        if (!$question || !$answer) {
            return redirect()->back()->with('error', 'Question or answer not found.');
        }

        // Check if the question is already closed
        if ($question->closed) {
            return redirect()->back()->with('error', 'This question is already closed.');
        }

        // Check if the question already has a chosen answer
        if ($question->answers()->where('chosen', true)->exists()) {
            return redirect()->back()->with('error', 'This question already has a chosen answer.');
        }

        // Only allow the question author to choose an answer
        if (auth()->id() !== $question->author->id) {
            return redirect()->back()->with('error', 'You are not authorized to mark this answer as chosen.');
        }

        // Set this answer as chosen
        $answer->chosen = true;
        $answer->save();

        // Optionally, close the question if a chosen answer is set
        $question->closed = true;
        $question->save();

        return redirect()->back()->with('success', 'Answer chosen successfully!');
    }

    /*
    Delete -------------------------------------------------------------------------------------------------------------------------
    */

    public function deleteQuestion($id)
    {
        // Retrieve the question
        $question = Question::with(['answers', 'tags'])->findOrFail($id);

        // Check if the authenticated user is the author or an admin
        if (Auth::id() !== $question->author_id && !Auth::user()->is_mod) {
            return redirect()->route('question.show', $id)->with('error', 'You are not authorized to delete this question.');
        }

        // Delete related answers
        foreach ($question->answers as $answer) {
            $answer->post()->delete(); // Delete the associated post
            $answer->delete(); // Delete the answer
        }

        $post = $question->post;
        $post->delete(); // Delete the post

        // Detach tags
        $question->tags()->detach();

        // Delete the question's post
        $question->post()->delete();

        // Delete the question
        $question->delete();

        // Redirect to a suitable page with success message
        return redirect()->route('home')->with('success', 'The question has been deleted successfully.');
    }

    public function deleteAnswer($id)
    {
        $answer = Answer::findOrFail($id);

        // Check if the authenticated user is the author or an admin
        if (Auth::id() !== $answer->author_id && !Auth::user()->is_mod) {
            return redirect()->route('question.show', $answer->question->id)->with('error', 'You are not authorized to delete this answer.');
        }

        $post = $answer->post;
        $post->delete(); // Delete the post

        $answer->delete(); // Delete the answer

        // Redirect to a suitable page with success message
        return redirect()->route('question.show', $answer->question->id)->with('success', 'The answer has been deleted successfully.');
    }


}


