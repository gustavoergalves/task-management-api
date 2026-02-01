<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\EmployeeTask\EmployeeTaskData;
use App\Exceptions\EmployeeTaskNotFoundException;
use App\Models\EmployeeTask;
use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EmployeeTaskRepository implements EmployeeTaskRepositoryInterface
{
    public function assign(EmployeeTaskData $data): EmployeeTask
    {
        /** @var EmployeeTask $employeeTask */
        $employeeTask = EmployeeTask::query()->create([
            'employee_id' => $data->employeeId,
            'task_id' => $data->taskId,
        ]);

        return $employeeTask->load(['employee', 'task']);
    }

    /**
     * @throws EmployeeTaskNotFoundException
     */
    public function unassign(int $employeeId, int $taskId): void
    {
        $employeeTask = $this->findByEmployeeAndTask($employeeId, $taskId);

        if (! $employeeTask) {
            throw new EmployeeTaskNotFoundException('Assignment not found');
        }

        $employeeTask->delete();
    }

    public function getByEmployee(int $employeeId): Collection
    {
        return EmployeeTask::query()
            ->where('employee_id', $employeeId)
            ->with('task')
            ->get();
    }

    public function getByTask(int $taskId): Collection
    {
        return EmployeeTask::query()
            ->where('task_id', $taskId)
            ->with('employee')
            ->get();
    }

    public function findByEmployeeAndTask(int $employeeId, int $taskId): ?EmployeeTask
    {
        /** @var EmployeeTask|null $employeeTask */
        $employeeTask = EmployeeTask::query()
            ->where('employee_id', $employeeId)
            ->where('task_id', $taskId)
            ->first();

        return $employeeTask;
    }
}
