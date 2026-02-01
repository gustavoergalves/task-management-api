<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EmployeeTask;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\Task;
use Tests\TestCase;

class ListAssignmentsByTaskControllerTest extends TestCase
{
    public function test_when_task_has_assignments_then_it_should_return_list(): void
    {
        /** @var Task $task */
        $task = Task::query()->create([
            'title' => 'Test Task',
            'status' => TaskStatusEnum::PENDING->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
        ]);

        /** @var Employee $employee1 */
        $employee1 = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        /** @var Employee $employee2 */
        $employee2 = Employee::query()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        EmployeeTask::query()->create([
            'employee_id' => $employee1->id,
            'task_id' => $task->id,
        ]);

        EmployeeTask::query()->create([
            'employee_id' => $employee2->id,
            'task_id' => $task->id,
        ]);

        $response = $this->getJson("/api/assignments/task/{$task->id}");

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(2, $data);
    }

    public function test_when_task_has_no_assignments_then_it_should_return_empty_list(): void
    {
        /** @var Task $task */
        $task = Task::query()->create([
            'title' => 'Test Task',
            'status' => TaskStatusEnum::PENDING->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
        ]);

        $response = $this->getJson("/api/assignments/task/{$task->id}");

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(0, $data);
    }
}
