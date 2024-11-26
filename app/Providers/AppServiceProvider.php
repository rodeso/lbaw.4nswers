<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Question;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(env('FORCE_HTTPS', false)) {
            error_log('configuring https');
    
            $app_url = config("app.url");
            URL::forceRootUrl($app_url);
            $schema = explode(':', $app_url)[0];
            URL::forceScheme($schema);
        }
    
        // Share the urgent question with all views
        View::composer('*', function ($view) {
            // Fetch the question that is about to expire
            $urgentQuestion = Question::with(['tags', 'post'])
                ->orderBy('time_end', 'asc') // Sort by time_end in ascending order (earliest deadlines first)
                ->where('time_end', '>', now())
                ->first(); // Get the question with the soonest expiration
    
            // Pass the urgent question to all views
            $view->with('urgentQuestion', $urgentQuestion);
        });
    }
    
}
