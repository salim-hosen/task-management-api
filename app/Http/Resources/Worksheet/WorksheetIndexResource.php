<?php

namespace App\Http\Resources\Worksheet;

use Illuminate\Http\Resources\Json\JsonResource;

class WorksheetIndexResource extends JsonResource
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
            "project_name" => $this->project->name,
            "task_name" => $this->task->description,
            "note" => $this->note,
            "time" => $this->time,
            "date" => $this->date,
            "username" => $this->user->name
        ];

    }
}
