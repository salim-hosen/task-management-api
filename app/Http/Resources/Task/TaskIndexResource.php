<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'close_date' => $this->close_date,
            'is_complete' => $this->is_complete,
            'status' => $this->status,
            'working_hours' => $this->worksheets()->sum("time")
        ];
    }
}
