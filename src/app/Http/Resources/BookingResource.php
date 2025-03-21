<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property int $user_id
 * @property int $resource_id
 * @property string $start_time
 * @property string $end_time
 */
class BookingResource extends JsonResource
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
            'resource_id' => $this->resource_id,
            'resource' => $this->whenLoaded('resource'),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
