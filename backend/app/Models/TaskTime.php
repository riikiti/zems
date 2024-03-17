<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class TaskTime extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'time_start', 'time_finish'];

    protected $casts = [
        'time_start' => 'datetime',
        'time_finish' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    protected function time(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $totalTime = $this->time_finish->diffInSeconds($this->time_start);
                $totalDays = floor($totalTime / 86400);
                $totalTime = $totalTime % 86400;
                return
                    $totalDays . ' дней(ня) ' . CarbonInterval::seconds($totalTime)->cascade()->forHumans();
            }
        );
    }

    public function scopeCreatedAt(Builder $query): Builder
    {
        return $query->orderBy('created_at');
    }
}
