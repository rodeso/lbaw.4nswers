<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModeratorNotification;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Question;
use App\Models\ReportNotification;


class NotificationController extends Controller
{

    // Report

    public function showReportForm($id)
    {

        $notifications = Controller::getNotifications();

        // Retrieve the post (question, answer, or comment)
        $post = Post::findOrFail($id);
    
        // Pass the post to the view
        return view('create-report', compact('post', 'notifications'));
    }
    
    public function reportPost(Request $request, $id)
    {
        $notifications = Controller::getNotifications();

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
            $questionId = $post->question->id ?? null;
        }
        // If the post is an answer, get the associated question ID
        elseif ($post->answer) {
            $questionId = $post->answer->question_id ?? null;
        }
        // If the post is a comment, get the associated answer's question ID
        elseif ($post->comment) {
            $questionId = $post->comment->answer->question->id ?? null;
        }

        // If no question ID is found, throw an error
        if (!$questionId) {
            return redirect()->back()->withErrors(['error' => 'Unable to determine the associated question.']);
        }

        // Post a report (notification) for the post
        $notification = Notification::create([
            'content' => $request->content,
            'time_stamp' => now(),
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);
        ReportNotification::create([
            'notification_id' => $notification->id,
            'report' => $request->reason,
        ]);

        // Redirect to the associated question page
        return redirect()->route('question.show', $questionId)->with('success', 'Post reported successfully.');
    }
        

    // Flag

    public function showFlagForm($id)
    {

        $notifications = Controller::getNotifications();

        // Retrieve the post (question, answer, or comment)
        $post = Post::findOrFail($id);
    
        // Pass the post to the view
        return view('create-flag', compact('post', 'notifications'));
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
            $questionId = $post->question->id ?? null;
        }
        // If the post is an answer, get the associated question ID
        elseif ($post->answer) {
            $questionId = $post->answer->question_id ?? null;
        }
        // If the post is a comment, get the associated answer's question ID
        elseif ($post->comment) {
            $questionId = $post->comment->answer->question->id ?? null;
        }

        // If no question ID is found, throw an error
        if (!$questionId) {
            return redirect()->back()->withErrors(['error' => 'Unable to determine the associated question.']);
        }

        // Check if a ModeratorNotification already exists for this post
        $existingModeratorNotification = ModeratorNotification::whereHas('notification', function ($query) use ($post) {
            $query->where('post_id', $post->id);
        })->first();

        if ($existingModeratorNotification) {
            // Update the existing ModeratorNotification
            $existingModeratorNotification->notification->update([
                'content' => $request->content,
                'time_stamp' => now(),
                'user_id' => auth()->id(),
            ]);

            // Update the reason in the ModeratorNotification
            $existingModeratorNotification->update([
                'reason' => $request->reason,
            ]);
        } else {
            // Create a new Notification
            $notification = Notification::create([
                'content' => $request->content,
                'time_stamp' => now(),
                'post_id' => $post->id,
                'user_id' => auth()->id(),
            ]);

            // Create a new ModeratorNotification
            ModeratorNotification::create([
                'notification_id' => $notification->id,
                'reason' => $request->reason,
            ]);
        }


        // Redirect to the associated question page
        return redirect()->route('question.show', $questionId)
                        ->with('success', 'Post flagged successfully.');
    }

    public function deleteFlag($id)
    {
        // Find the ModeratorNotification for the given post ID via its related Notification
        $moderatorNotification = ModeratorNotification::whereHas('notification', function ($query) use ($id) {
            $query->where('post_id', $id);
        })->first();

        if (!$moderatorNotification) {
            // If no ModeratorNotification is found, redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'No moderator flag exists for this post.']);
        }

        // Delete the ModeratorNotification
        $moderatorNotification->delete();

        // Delete the associated Notification
        $moderatorNotification->notification->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Flag deleted successfully.');
    }


}
