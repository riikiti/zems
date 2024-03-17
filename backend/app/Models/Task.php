<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function times(): HasMany
    {
        return $this->hasMany(TaskTime::class, 'task_id', 'id');
    }

    protected function totalTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                $totalTime = $this->times()->get()->reduce(function ($carry, $taskTime) {
                    return $carry + $taskTime->time_finish->diffInSeconds($taskTime->time_start);
                }, 0);

                $totalDays = floor($totalTime / 86400);
                $totalTime = $totalTime % 86400;

                return
                    $totalDays . ' дней(ня) ' . CarbonInterval::seconds($totalTime)->cascade()->forHumans();
            }
        );
    }
}
