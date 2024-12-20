<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Question::class => \App\Policies\QuestionPolicy::class,
        \App\Models\Answer::class => \App\Policies\AnswerPolicy::class,
        \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define abilities for users
        Gate::define('delete-user', [\App\Policies\UserPolicy::class, 'delete']);
        Gate::define('moderator', [\App\Policies\UserPolicy::class, 'moderator']);
        Gate::define('admin', [\App\Policies\UserPolicy::class, 'admin']);

        // Define abilities for questions
        Gate::define('update-question', [\App\Policies\QuestionPolicy::class, 'update']);
        Gate::define('updateTags-question', [\App\Policies\QuestionPolicy::class, 'updateTags']);
        Gate::define('close-question', [\App\Policies\QuestionPolicy::class, 'close']);
        Gate::define('delete-question', [\App\Policies\QuestionPolicy::class, 'delete']);
        
        // Define abilities for answers
        Gate::define('update-answer', [\App\Policies\AnswerPolicy::class, 'update']);
        Gate::define('delete-answer', [\App\Policies\AnswerPolicy::class, 'delete']);

        // Define abilities for comments
        Gate::define('update-comment', [\App\Policies\CommentPolicy::class, 'update']);
        Gate::define('delete-comment', [\App\Policies\CommentPolicy::class, 'delete']);

    }
}
