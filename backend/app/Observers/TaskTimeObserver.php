<?php

namespace App\Observers;

use App\Models\TaskTime;
use Illuminate\Support\Facades\Cache;

class TaskTimeObserver
{
    public function created(TaskTime $time)
    {
        Cache::forget('times');
    }
}
