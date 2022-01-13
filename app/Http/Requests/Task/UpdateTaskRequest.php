<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "project_id" => ["required"],
            "user_id" => ["required"],
            "description" => ["required"],
            "start_date" => ["required"],
            "close_date" => ["required"],
            "is_complete" => ["required"],
            "status" => ["required"]
        ];
    }
}
