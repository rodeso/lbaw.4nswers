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
        // Retrieve questions where 'closed' is false and 'time_end' has passed
        $questions = Question::where('closed', false)
            ->where('time_end', '<', now())
            ->update(['closed' => true]);


        $this->info("Expired questions successfully processed.");
    }


}

