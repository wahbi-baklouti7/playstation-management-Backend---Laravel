<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
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
            'amount' => $this->amount,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            // 'user' => $this->user),
            // 'device' => new DeviceResource($this->device),
            // 'game' => new GameResource($this->game),
            'user' => $this->user,
            'device' => $this->device,
            'game' => $this->game,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];


    }
}
