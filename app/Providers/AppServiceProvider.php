<?php

namespace App\Providers;

use App\Models\SurveyQuestion;
use App\Observers\SurveyQuestionObserver;
use Illuminate\Support\ServiceProvider;

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
        SurveyQuestion::observe(SurveyQuestionObserver::class);
    }
}
