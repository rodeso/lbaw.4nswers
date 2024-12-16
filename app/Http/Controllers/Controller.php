<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function getNotifications()
    {
        $loggedUserId = auth()->id(); // Get the logged-in user ID
    
        // Fetch all notifications
        $voteNotifications = $this->getVoteNotifications($loggedUserId);
        $answerNotifications = $this->getAnswerNotifications($loggedUserId);
        $helpfulNotifications = $this->getHelpfulNotifications($loggedUserId);
    
        // Combine notifications and sort them
        $notifications = DB::query()
            ->fromSub(
                $voteNotifications
                    ->union($answerNotifications)
                    ->union($helpfulNotifications), // Combine all notification queries
                'combined_notifications'
            )
            ->orderBy('time_stamp', 'desc') // Sort results by timestamp
            ->get();
    
        // Manually cast 'time_stamp' to Carbon instance for all notifications
        foreach ($notifications as $notification) {
            $notification->time_stamp = Carbon::parse($notification->time_stamp);
        }
    
        return $notifications;
    }

    /**
     * Get vote notifications for the logged-in user.
     */
    private function getVoteNotifications($loggedUserId)
    {
        return DB::table('vote_notification')
            ->join('notification', 'vote_notification.notification_id', '=', 'notification.id')
            ->join('post', 'notification.post_id', '=', 'post.id')
            ->leftJoin('question', 'post.id', '=', 'question.post_id')
            ->leftJoin('answer', 'post.id', '=', 'answer.post_id')
            ->where(function ($query) use ($loggedUserId) {
                $query->where('question.author_id', $loggedUserId)
                    ->orWhere('answer.author_id', $loggedUserId);
            })
            ->select(
                'notification.id as notification_id',
                'notification.content',
                'notification.time_stamp',
                'question.id as question_id',
                'answer.question_id as answer_question_id',
                'question.title as question_title', // Question title for questions
                'post.body as answer_body' // Post body for answers
            );
    }

    /**
     * Get answer notifications for the logged-in user.
     */
    private function getAnswerNotifications($loggedUserId)
    {
        return DB::table('answer_notification')
            ->join('notification', 'answer_notification.notification_id', '=', 'notification.id')
            ->join('post', 'notification.post_id', '=', 'post.id')
            ->leftJoin('answer', 'post.id', '=', 'answer.post_id')
            ->leftJoin('question', 'answer.question_id', '=', 'question.id')
            ->where('question.author_id', $loggedUserId) // Ensure the user owns the question
            ->select(
                'notification.id as notification_id',
                'notification.content',
                'notification.time_stamp',
                'question.id as question_id',
                'answer.question_id as answer_question_id',
                'question.title as question_title', // Question title related to the answer
                'post.body as answer_body' // Answer body
            );
    }
    
    /**
     * Get helpful notifications for the logged-in user.
     */
    private function getHelpfulNotifications($loggedUserId)
    {
        return DB::table('helpful_notification')
            ->join('notification', 'helpful_notification.notification_id', '=', 'notification.id')
            ->join('post', 'notification.post_id', '=', 'post.id')
            ->join('answer', 'post.id', '=', 'answer.post_id')
            ->join('question', 'answer.question_id', '=', 'question.id')
            ->where('answer.author_id', $loggedUserId) // Helpful notifications are for the user who made the answer
            ->select(
                'notification.id as notification_id',
                'notification.content',
                'notification.time_stamp',
                'question.id as question_id',
                'answer.question_id as answer_question_id',
                'question.title as question_title',
                'post.body as answer_body'
            );
    }
    
}
