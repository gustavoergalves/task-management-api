<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', Rule::enum(TaskStatusEnum::class)],
            'priority' => ['required', 'string', Rule::enum(TaskPriorityEnum::class)],
            'dueDate' => ['nullable', 'date_format:Y-m-d'],
        ];
    }
}
