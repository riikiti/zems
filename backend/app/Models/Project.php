<?php

namespace App\Models;

use App\Services\Helpers\Images\ImageHelperService;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'logo'];

    private ImageHelperService $imageHelper;

    public function __construct()
    {
        $this->imageHelper = app(ImageHelperService::class);
        $this->imageHelper->setSavingPath('avatars');
    }

    public function setLogoAttribute($value): void
    {
        $this->attributes['logo'] = $this->imageHelper->handleImageUpload(
            value: $value,
            model: $this,
            attribute: 'logo'
        );
        $this->save();
    }

    protected function createdValue(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->format('d.m.Y'),
        );
    }

    public function getTotalTimeAttribute()
    {
        $totalTime = 0;
        $day = '';
        foreach ($this->tasks as $task) {
            foreach ($task->times as $time) {
                $totalTime += $time->time_finish->diffInSeconds($time->time_start);
            }
        }
        $totalDays = floor($totalTime / 86400);
        $totalTime = $totalTime % 86400;

        return
            $totalDays . ' дней(ня) ' . CarbonInterval::seconds($totalTime)->cascade()->forHumans();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }
}
