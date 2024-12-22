<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Post;
use App\Models\Tag;
use App\Models\UserFollowsTag;
use App\Models\PopularityVote;
use App\Models\AuraVote;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Models\UserFollowsQuestion;
use App\Models\Notification;
use App\Models\AnswerNotification;
use App\Models\HelpfulNotification;


class PostController extends Controller
{   
    // Post page
    public function show($id)
    {   

        $notifications = Controller::getNotifications();

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

        // First, calculate aura for each answer
        foreach ($question->answers as $answer) {
            $answer->aura = PostController::aura($answer->id);
        }

        $sortedAnswers = $question->answers->sortByDesc(function ($answer) {
            // First, check if the answer is chosen. You can replace `is_chosen` with the actual field or method that determines if it's chosen.
            if ($answer->chosen) {
                return PHP_INT_MAX; // Put the chosen answer at the top
            }
            // Otherwise, sort by aura
            return $answer->aura;
        });

       
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
        $isFollowing = auth()->check() && $question->isFollowedByUser(auth()->id());
    
        // Pass data to view
        return view('post', compact('question', 'sortedAnswers', 'user_tags', 'userVote', 'isFollowing', 'notifications'));
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

        $this->authorize('unblocked'); 

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

        $this->authorize('unblocked'); 

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
            'author_id' => Auth::id(),
            'question_id' => $validated['question_id'],
            'post_id' => $post->id,
        ]);

        // Save the answer
        $answer->save();

        // Create a notification for the answer
        $notification = new Notification([
            'content' => 'New answer by ' . Auth::user()->nickname, // Example content
            'time_stamp' => now(),
            'post_id' => $post->id, // The post associated with the answer
            'user_id' => Auth::id(), // The user who wrote the answer
        ]);
        $notification->save();

        // Create an entry in the answer_notification table
        $answerNotification = new AnswerNotification([
            'notification_id' => $notification->id,
        ]);
        $answerNotification->save();

        // Redirect or return success response
        return redirect()->route('question.show', ['id' => $validated['question_id']]);
    }

    public function storeComment(Request $request, $answerId)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:4096',
        ]);

        $this->authorize('unblocked'); 

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

    public function followQuestion(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $question = Question::findOrFail($id);

        // Check if the user already follows the question
        if ($user->followedQuestions()->where('id', $id)->exists()) {
            $user->followedQuestions()->detach($question);
            return redirect()->back()->with('success', 'Question unfollowed!');
        }

        // Add the relationship
        $user->followedQuestions()->attach($question);

        return redirect()->back()->with('success', 'Question followed!');
        
    }

    /*
    Show -------------------------------------------------------------------------------------------------------------------------
    */

    public function showNewQuestion()
    {
        $notifications = Controller::getNotifications();
        
        if (!Auth::check()) {
            // Redirect to home with an alert
            return redirect()->route('home')->with('alert', 'You must be logged in to post a new question!');
        }

        $this->authorize('unblocked'); 

        // Tags that user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if logged in user is null
        
        // Extract all the tags
        $tags = Tag::all();
    
        // Pass the tags to the view
        return view('new-question', compact('tags', 'user_tags', 'notifications'));
    }

    public function showEditQuestion($id)
    {
        $notifications = Controller::getNotifications();

        $question = Question::with('tags')->findOrFail($id);

        // Check if the logged-in user is the author of the question 
        $this->authorize('update-question', $question);

        $post = Post::findOrFail($question->post_id);

        // Tags that the user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect();

        // Extract all the tags for selection
        $tags = Tag::all();

        return view('edit-question', compact('tags', 'user_tags', 'question', 'post', 'notifications'));
    }

    public function showEditTags($id)
    {
        $notifications = Controller::getNotifications();

        $question = Question::with('tags')->findOrFail($id);

        // Check if the logged-in user is the author of the question or a moderator
        $this->authorize('updateTags-question', $question);

        // Tags that the user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect();

        // Extract all the tags for selection
        $tags = Tag::all();

        return view('edit-question-tags', compact('tags', 'user_tags', 'question', 'notifications'));
    }

    public function showEditAnswer($id)
    {
        $notifications = Controller::getNotifications();
        
        $answer = Answer::findOrFail($id);

        $this->authorize('update-answer', $answer);

        $post = Post::findOrFail($answer->post_id);

        // Tags that the user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect();


        return view('edit-answer', compact('user_tags', 'answer', 'post', 'notifications'));
    }

    public function showEditComment($id)
    {
        $notifications = Controller::getNotifications();
        
        $comment = Comment::findOrFail($id);

        $this->authorize('update-comment', $comment);

        $post = Post::findOrFail($comment->post_id);

        // Tags that the user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect();


        return view('edit-comment', compact('user_tags', 'comment', 'post', 'notifications'));
    }


    /*
    Votes -------------------------------------------------------------------------------------------------------------------------
    */

    public function vote(Request $request, $questionId)
    {
        $this->authorize('unblocked'); 
        
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
        $voteChanged = false;
        
        if ($existingVote) {
            // If the user clicks the same button twice, remove the vote (undo)
            if (($voteType === 'upvote' && $existingVote->is_positive) ||
                ($voteType === 'downvote' && !$existingVote->is_positive)) {
                $existingVote->delete();
                $voteUndone = true; // Mark that vote was undone
                $voteChanged = -1;

                // Return the updated vote count and voteUndone flag
                $totalVotes = PopularityVote::where('question_id', $questionId)
                    ->where('is_positive', true)->count()
                    - PopularityVote::where('question_id', $questionId)
                    ->where('is_positive', false)->count();
                
                // Update cumulative votes and aura
                if ($voteChanged !== 0) {
                    $user = User::find($userId);
                    $user->votes_processed += $voteChanged;

                    if ($user->votes_processed >= 5) {
                        $user->votes_processed -= 5; // Reset for next cycle
                        $user->aura += 1; // Grant 1 aura
                    }

                    $user->save();
                }
        
                return response()->json(['totalVotes' => $totalVotes, 'voteUndone' => $voteUndone]);
            }

            // Otherwise, update the vote
            $voteChanged = 0;
            $existingVote->is_positive = ($voteType === 'upvote');
            $existingVote->save();
        } else {
            // Create a new vote if none exists
            PopularityVote::create([
                'user_id' => $userId,
                'question_id' => $questionId,
                'is_positive' => ($voteType === 'upvote'),
            ]);
            $voteChanged = 1;
        }

        // Update cumulative votes and aura
        if ($voteChanged !== 0) {
            $user = User::find($userId);
            $user->votes_processed += $voteChanged;

            if ($user->votes_processed >= 5) {
                $user->votes_processed -= 5; // Reset for next cycle
                $user->aura += 1; // Grant 1 aura
            }

            $user->save();
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
        $this->authorize('unblocked'); 

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

        $voteChanged = false;

        if ($existingVote) {
            if ($existingVote->is_positive === $isPositive) {
                $existingVote->delete(); // Remove the vote
                $voteChanged = -1;
            } else {
                $existingVote->is_positive = $isPositive;
                $existingVote->save(); // Save the updated vote
                $voteChanged = 0;
            }
        } else {
            AuraVote::create([
                'user_id' => $userId,
                'answer_id' => $answerId,
                'is_positive' => $isPositive,
            ]);
            $voteChanged = 1;
        }

        if ($voteChanged !== 0) {
            $user = User::find($userId);
            $user->votes_processed += $voteChanged;
    
            if ($user->votes_processed >= 10) {
                $user->votes_processed -= 10; // Reset for next cycle
                $user->aura += 1; // Grant 1 aura
            }
    
            $user->save();
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

    public function aura($answerId)
    {
        return AuraVote::where('answer_id', $answerId)
            ->where('is_positive', true)
            ->count()
            - AuraVote::where('answer_id', $answerId)
            ->where('is_positive', false)
            ->count();
    }

    public function popularity($questionId)
    {
        return PopularityVote::where('question_id', $questionId)
            ->where('is_positive', true)
            ->count()
            - PopularityVote::where('question_id', $questionId)
            ->where('is_positive', false)
            ->count();
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

        // Ensure the user has permission to update this question
        $this->authorize('update-question', $question);

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

    public function updateTags(Request $request, $id)
    {
        $validated = $request->validate([
            'selected_tags' => 'nullable|string', // Comma-separated tag IDs
            'new_tags' => 'nullable|string', // JSON string of new tag objects
        ]);

        // Retrieve the question
        $question = Question::findOrFail($id);

        // Ensure the user has permission to update this question
        $this->authorize('updateTags-question', $question);

        // Process selected existing tags
        $selectedTagIds = [];
        if (!empty($validated['selected_tags'])) {
            $selectedTagIds = array_filter(explode(',', $validated['selected_tags']), function ($tagId) {
                return !empty($tagId) && is_numeric($tagId);
            });
        }

        // Detach all current tags
        $question->tags()->detach();

        // Attach the selected existing tags
        if (!empty($selectedTagIds)) {
            $question->tags()->attach($selectedTagIds);
        }

        // Handle creation of new tags
        $newTags = [];
        if (!empty($validated['new_tags'])) {
            $newTags = json_decode($validated['new_tags'], true);
        }

        foreach ($newTags as $newTag) {
            if (!empty($newTag['name']) && !empty($newTag['description'])) {
                $createdTag = Tag::create([
                    'name' => $newTag['name'],
                    'description' => $newTag['description'],
                ]);
                $question->tags()->attach($createdTag->id); // Attach the newly created tag
            }
        }

        return redirect()->route('question.show', $question->id)
            ->with('success', 'Tags updated successfully!');
    }

    public function updateAnswer(Request $request, $id)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:4096',
        ]);

        // Find the answer and update it
        $answer = Answer::findOrFail($id);

        // Ensure the user has permission to update this answer
        $this->authorize('update-answer', $answer);

        $post = Post::findOrFail($answer->post_id);
        $post->update([
            'body' => $validated['body'],
        ]);

        return redirect()->route('question.show', $answer->question->id)->with('success', 'Answer updated successfully!');
    }

    public function updateComment(Request $request, $id)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:4096',
        ]);

        // Find the answer and update it
        $comment = Comment::findOrFail($id);

        // Ensure the user has permission to update this comment
        $this->authorize('update-comment', $comment);

        $post = Post::findOrFail($comment->post_id);
        $post->update([
            'body' => $validated['body'],
        ]);

        return redirect()->route('question.show', $comment->answer->question->id)->with('success', 'Comment updated successfully!');
    }

    private function finalizeQuestionClosure($question)
    {   
        // Get the question's author ID
        $questionAuthorId = $question->author_id;
    
        // Count answers not authored by the question's author
        $numAnswers = Answer::where('question_id', $question->id)
            ->where('author_id', '!=', $questionAuthorId)
            ->count();
        
        // Srted answers by aura also now authored by the question's author TODO
        $sortedAnswers = $question->answers
            ->filter(function ($answer) use ($questionAuthorId) {
                return $answer->author_id != $questionAuthorId;
            })
            ->sortByDesc(function ($answer) {
                return PostController::aura($answer->id);
            });
    
        // Get popularity votes
        $popularVotes = $this->popularity($question->id);
    
        if ($popularVotes > 0) {
            $bonusResponders = $popularVotes * 4;
            $bonus1 = ceil($bonusResponders * (40 / 100));
            $bonus2 = ceil($bonusResponders * (20 / 100));
            $bonus3 = ceil($bonusResponders * (12.5 / 100));
            $bonus4 = ceil($bonusResponders * (7.5 / 100));
    
            $topAnswers = $sortedAnswers->take(4);
            $bonuses = [$bonus1, $bonus2, $bonus3, $bonus4];
    
            foreach ($topAnswers as $index => $answer) {
                $answerAuthor = User::find($answer->author_id);
                $answerAuthor->aura += $bonuses[$index];
                $answerAuthor->save();
            }
        }
     
        // Initialize aura points
        $bonusAuraPoints = 0;
    
        // Apply the aura point logic
        if ($popularVotes >= 5) {
            $bonusAuraPoints += ($popularVotes - 5) * 2;
        }
        if ($numAnswers >= 3) {
            $bonusAuraPoints += ($numAnswers - 3) * 2;
        }
    
        // Update the author's aura if bonusAuraPoints > 0
        if ($bonusAuraPoints > 0) {
            $author = $question->author;
            $author->aura += $bonusAuraPoints;
            $author->save();
        }
    
        // Close the question
        $question->closed = true;
        $question->save();
    }

    public function closeQuestion($id)
    {
        DB::beginTransaction();
        try {
            // Retrieve the question
            $question = Question::findOrFail($id);
    
            // Check if the authenticated user is the author or an admin
            $this->authorize('close-question', $question);

            $this->finalizeQuestionClosure($question);
    
            // Commit the transaction
            DB::commit();
    
            return redirect()->route('question.show', $id)->with('success', 'Question closed successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
    
            return redirect()->route('question.show', $id)->with('error', 'Failed to close question!');
        }
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
        $this->authorize('choose-question', $question);

        // Set this answer as chosen
        $answer->chosen = true;
        $answer->save();
    
        // Optionally, close the question if a chosen answer is set
        $question->closed = true;
        $question->save();
    
        // Create the notification
        $notification = new Notification([
            'content' => 'Your answer has been chosen!', // Notification message
            'time_stamp' => now(),
            'post_id' => $answer->post_id, // The post associated with the chosen answer
            'user_id' => $question->author_id, // The user who chose the answer (author of the question)
        ]);
        $notification->save();

        // Create the helpful_notification
        $helpfulNotification = new HelpfulNotification([
            'notification_id' => $notification->id, // Reference to the notification
        ]);
        $helpfulNotification->save();

        DB::beginTransaction();
        try {
            $this->finalizeQuestionClosure($question);

            // Commit the transaction
            DB::commit();
    
            return redirect()->back()->with('success', 'Answer chosen successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
    
            return redirect()->back()->with('error', 'Failed to choose the answer!');
        }
      
    }
    

    /*
    Delete -------------------------------------------------------------------------------------------------------------------------
    */

    public function deleteQuestion($id)
    {
        // Retrieve the question
        $question = Question::with(['answers', 'tags'])->findOrFail($id);

        // Check if the authenticated user is the author or an admin
        $this->authorize('delete-question', $question);

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
        $this->authorize('delete-answer', $answer);

        $post = $answer->post;
        $post->delete(); // Delete the post

        $answer->delete(); // Delete the answer

        // Redirect to a suitable page with success message
        return redirect()->route('question.show', $answer->question->id)->with('success', 'The answer has been deleted successfully.');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user is the author or an admin
        $this->authorize('delete-comment', $comment);

        $post = $comment->post;
        $post->delete(); // Delete the post

        $comment->delete(); // Delete the comment

        // Redirect to a suitable page with success message
        return redirect()->route('question.show', $comment->answer->question->id)->with('success', 'The answer has been deleted successfully.');
    }


}


