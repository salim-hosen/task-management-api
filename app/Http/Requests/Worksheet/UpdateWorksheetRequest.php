<?php

namespace App\Http\Requests\Worksheet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorksheetRequest extends FormRequest
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
            "task_id" => ["required"],
            "user_id" => ["required"],
            "time" => ["required"],
            "date" => ["required"],
            "note" => ["required"]
        ];
    }
}
