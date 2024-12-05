<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModeratorNotification;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Question;

class NotificationController extends Controller
{
    public function showFlagForm($id)
    {
        // Retrieve the post (question, answer, or comment)
        $post = Post::findOrFail($id);
    
        // Pass the post to the view
        return view('create-flag', compact('post'));
    }
    

    public function flagPost(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'content' => 'required|string|max:4096',
        ]);
    
        // Find the post by ID
        $post = Post::findOrFail($id);
    
        // Determine the post type by checking its relationships
        $questionId = null;
    
        // If the post is a question, get the question ID
        if ($post->question) {
            $questionId = $post->question->id;
        }
        // If the post is an answer, get the associated question ID
        elseif ($post->answer) {
            $questionId = $post->answer->question_id;
        }
        // If the post is a comment, get the associated answer's question ID
        elseif ($post->comment) {
            $questionId = $post->comment->answer->question_id;
        }
    
        // Create a new notification
        $notification = Notification::create([
            'content' => $request->content,
            'time_stamp' => now(),
            'post_id' => $post->id,
            'user_id' => auth()->id(), // Logged-in moderator's ID
        ]);
    
        // Create a moderator notification
        ModeratorNotification::create([
            'notification_id' => $notification->id,
            'reason' => $request->reason,
        ]);
    
        // Redirect to the associated question page
        return redirect()->route('question.show', $questionId)
                         ->with('success', 'Post flagged successfully.');
    }
    


    
    
}
