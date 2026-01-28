<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['string', Rule::enum(TaskStatusEnum::class)],
            'priority' => ['string', Rule::enum(TaskPriorityEnum::class)],
        ];
    }
}
