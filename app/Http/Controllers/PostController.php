<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Post;
use App\Models\Tag;
use App\Models\UserFollowsTag;
use App\Models\PopularityVote;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show($id)
    {
        // Retrieve the specific question with its related data
        $question = Question::with(['post', 'answers.post', 'tags', 'author', 'answers.author'])->findOrFail($id);
    
        // Tags that user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if logged in user is null
    
        // Get the user's vote (if they have voted)
        $userVote = null;
        if (auth()->check()) {
            $userVote = PopularityVote::where('user_id', auth()->id())
                ->where('question_id', $id)
                ->value('is_positive');
        }
    
        // Pass the question, tags, and userVote to the view
        return view('post', compact('question', 'user_tags', 'userVote'));
    }
    

    public function showNewQuestion()
    {
        // Tags that user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if logged in user is null
        
        // Extract all the tags
        $tags = Tag::all();
    
        // Pass the tags to the view
        return view('new-question', compact('tags', 'user_tags'));
    }

    public function storeAnswer(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:4096',
            'question_id' => 'required|exists:question,id',
        ]);

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

    public function vote(Request $request, $questionId)
    {
        $userId = auth()->id();
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

}


