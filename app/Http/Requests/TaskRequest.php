<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'project_id'  => ['required', 'exists:projects,id'],
            'user_id'     => ['required', 'exists:users,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:pending,in_progress,completed'],
            'due_date'    => ['required', 'date'],
        ];
    }
}
