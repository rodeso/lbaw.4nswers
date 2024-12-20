<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;
use App\Http\Controllers\PostController;


class CloseExpiredQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'questions:close-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close questions whose time limit has expired';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $questionController = new PostController();

        // Retrieve questions where 'closed' is false and 'time_end' has passed
        $questions = Question::where('closed', false)
            ->where('time_end', '<', now())
            ->get();

        foreach ($questions as $question) {
            try {
                $questionController->closeQuestion($question->id); // Invoke closeQuestion
            } catch (\Exception $e) {
                $this->error("Failed to close question ID: {$question->id}. Error: {$e->getMessage()}");
            }
        }

        $this->info("Expired questions successfully processed.");
    }


}

