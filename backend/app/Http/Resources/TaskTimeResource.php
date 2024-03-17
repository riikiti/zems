<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'task_name'=>$this->task->name,
            'time_start' => $this->time_start->format('d.m.Y H:i:s'),
            'time_finish' => $this->time_finish->format('d.m.Y H:i:s'),
            'time' => $this->time
        ];
    }
}
