<?php

declare(strict_types=1);

namespace App\Data\EmployeeTask;

use App\Data\Employee\EmployeeData;
use App\Data\Task\TaskData;
use App\Http\Requests\EmployeeTask\AssignTaskRequest;
use App\Models\EmployeeTask;
use Spatie\LaravelData\Data;

class EmployeeTaskData extends Data
{
    public function __construct(
        public ?int $id,
        public int $employeeId,
        public int $taskId,
        public ?EmployeeData $employee,
        public ?TaskData $task,
    ) {}

    public static function fromModel(EmployeeTask $employeeTask): self
    {
        return new self(
            id: $employeeTask->id,
            employeeId: $employeeTask->employee_id,
            taskId: $employeeTask->task_id,
            employee: $employeeTask->relationLoaded('employee')
                ? EmployeeData::fromModel($employeeTask->employee)
                : null,
            task: $employeeTask->relationLoaded('task')
                ? TaskData::fromModel($employeeTask->task)
                : null,
        );
    }

    public static function fromRequest(AssignTaskRequest $request): self
    {
        return new self(
            id: null,
            employeeId: (int) $request->input('employeeId'),
            taskId: (int) $request->input('taskId'),
            employee: null,
            task: null,
        );
    }
}
