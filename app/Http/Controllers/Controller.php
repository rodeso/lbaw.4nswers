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
        $moderatorNotifications = $this->getModeratorNotifications($loggedUserId);
    
        // Combine notifications and sort them
        $notifications = DB::query()
            ->fromSub(
                $voteNotifications
                    ->union($answerNotifications)
                    ->union($helpfulNotifications)
                    ->union($moderatorNotifications), // Combine all notification queries
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
                'question.id as question_id', // Question ID if the notification is for a question
                'answer.question_id as answer_question_id', // Question ID of the answer if the notification is for an answer
                DB::raw('CAST(NULL AS INTEGER) as comment_question_id'), // Not used in vote notifications
                'question.title as question_title', // Question title for questions
                'post.body as post_body', // Post body for answers
                DB::raw('CAST(NULL AS TEXT) as reason') // Not used in vote notifications
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
                'question.id as question_id', // Question ID that received the new answer
                DB::raw('CAST(NULL AS INTEGER) as answer_question_id'), // Not used in answer notifications
                DB::raw('CAST(NULL AS INTEGER) as comment_question_id'), // Not used in answer notifications
                'question.title as question_title', // Question title related to the answer
                DB::raw('CAST(NULL AS TEXT) as post_body'), // Not used in answer notifications
                DB::raw('CAST(NULL AS TEXT) as reason') // Not used in answer notifications
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
                'question.id as question_id', // Question ID related to the chosen answer
                DB::raw('CAST(NULL AS INTEGER) as answer_question_id'), // Not used in helpful notifications
                DB::raw('CAST(NULL AS INTEGER) as comment_question_id'), // Not used in helpful notifications
                'question.title as question_title', // Question title related to the chosen answer
                DB::raw('CAST(NULL AS TEXT) as post_body'), // Not used in helpful notifications
                DB::raw('CAST(NULL AS TEXT) as reason') // Not used in helpful notifications
            );
    }

    /**
     * Get moderator notifications for the logged-in user.
     */
    private function getModeratorNotifications($loggedUserId)
    {
        return DB::table('moderator_notification')
            ->join('notification', 'moderator_notification.notification_id', '=', 'notification.id')
            ->join('post', 'notification.post_id', '=', 'post.id')
            ->leftJoin('question', 'post.id', '=', 'question.post_id')
            ->leftJoin('answer', 'post.id', '=', 'answer.post_id')
            ->leftJoin('comment', 'post.id', '=', 'comment.post_id')
            ->leftJoin('answer as comment_answer', 'comment.answer_id', '=', 'comment_answer.id') // Join to access question via answer
            ->where(function ($query) use ($loggedUserId) {
                $query->where('question.author_id', $loggedUserId)
                    ->orWhere('answer.author_id', $loggedUserId)
                    ->orWhere('comment.author_id', $loggedUserId);
            })
            ->select(
                'notification.id as notification_id',
                'notification.content', // Flag description
                'notification.time_stamp',
                'question.id as question_id', // Question ID if the flag is for a question
                'answer.question_id as answer_question_id', // Question ID of the answer if the flag is for an answer
                'comment_answer.question_id as comment_question_id', // Question ID of the comment if the flag is for a comment
                'question.title as question_title', // Question title for questions
                'post.body as post_body', // Post body for answers and comments
                'moderator_notification.reason as reason' // Reason for the flag
            );
    }
    
}
