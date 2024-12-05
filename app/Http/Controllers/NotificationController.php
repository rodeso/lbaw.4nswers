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
        $question = Question::findOrFail($id); // Corrected to fetch the Question model, not Notification
        return view('create-flag', compact('question'));
    }

    public function flagQuestion(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'content' => 'required|string|max:4096',
        ]);
    
        $question = Question::findOrFail($id); // Ensure you're retrieving a `Question` model
    
        // Create a new notification
        $notification = Notification::create([
            'content' => $request->content,
            'time_stamp' => now(),
            'post_id' => $question->post_id,
            'user_id' => auth()->id(), // Logged-in moderator's ID
        ]);
    
        // Create a moderator notification
        ModeratorNotification::create([
            'notification_id' => $notification->id,
            'reason' => $request->reason,
        ]);
    
        // Redirect back to the specific question
        return redirect()->route('question.show', $question->id)->with('success', 'Question flagged successfully.');
    }
    
}
