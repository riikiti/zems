<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskTime;
use App\Observers\ProjectObserver;
use App\Observers\TaskObserver;
use App\Observers\TaskTimeObserver;
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
        Project::observe(ProjectObserver::class);
        Task::observe(TaskObserver::class);
        TaskTime::observe(TaskTimeObserver::class);
    }
}
