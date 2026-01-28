<?php

declare(strict_types=1);

namespace App\Data\Task;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Http\Requests\Task\CreateUpdateTaskRequest;
use App\Models\Task;
use Spatie\LaravelData\Data;

class TaskData extends Data
{
    public function __construct(
        public ?int $id,
        public string $title,
        public ?string $description,
        public TaskStatusEnum $status,
        public TaskPriorityEnum $priority,
        public ?string $dueDate = null,
    ) {
    }

    public static function fromModel(Task $task): self
    {
        return new self(
            id: $task->id,
            title: $task->title,
            description: $task->description,
            status: $task->status,
            priority: $task->priority,
            dueDate: $task->due_date?->format('Y-m-d'),
        );
    }

    public static function fromRequest(CreateUpdateTaskRequest $request, ?int $id = null): self
    {
        return new self(
            id: $id,
            title: $request->input('title'),
            description: $request->input('description'),
            status: TaskStatusEnum::from($request->input('status')),
            priority: TaskPriorityEnum::from($request->input('priority')),
            dueDate: $request->input('dueDate'),
        );
    }
}
