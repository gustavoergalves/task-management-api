<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EmployeeTask;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\Task;
use Tests\TestCase;

class UnassignTaskControllerTest extends TestCase
{
    public function test_when_assignment_exists_then_it_should_unassign_successfully(): void
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        /** @var Task $task */
        $task = Task::query()->create([
            'title' => 'Test Task',
            'status' => TaskStatusEnum::PENDING->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
        ]);

        EmployeeTask::query()->create([
            'employee_id' => $employee->id,
            'task_id' => $task->id,
        ]);

        $response = $this->deleteJson("/api/assignments/employee/{$employee->id}/task/{$task->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('employee_task', [
            'employee_id' => $employee->id,
            'task_id' => $task->id,
        ]);
    }

    public function test_when_assignment_does_not_exist_then_it_should_return_not_found(): void
    {
        $response = $this->deleteJson('/api/assignments/employee/999/task/999');

        $response->assertNotFound();
    }
}
