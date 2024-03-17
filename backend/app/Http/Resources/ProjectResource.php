<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    private string $appUrl;

    public function toArray(Request $request): array
    {
        $this->appUrl = config('app.url');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'logo' => $this->logo ? $this->appUrl . '/storage/' . $this->logo : null,
            //'tasks' => $this->tasks ? TaskCompactResource::collection($this->tasks) : null,
            'total_time' =>$this->total_time
        ];
    }
}
