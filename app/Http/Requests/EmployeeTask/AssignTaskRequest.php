<?php

namespace App\Http\Requests\EmployeeTask;

use Illuminate\Foundation\Http\FormRequest;

class AssignTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employeeId' => ['required', 'integer'],
            'taskId' => ['required', 'integer'],
        ];
    }
}
