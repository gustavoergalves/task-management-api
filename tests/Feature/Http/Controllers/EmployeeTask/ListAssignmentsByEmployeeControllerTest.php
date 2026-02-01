<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EmployeeTask;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\Task;
use Tests\TestCase;

class ListAssignmentsByEmployeeControllerTest extends TestCase
{
    public function test_when_employee_has_assignments_then_it_should_return_list(): void
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        /** @var Task $task1 */
        $task1 = Task::query()->create([
            'title' => 'Task 1',
            'status' => TaskStatusEnum::PENDING->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
        ]);

        /** @var Task $task2 */
        $task2 = Task::query()->create([
            'title' => 'Task 2',
            'status' => TaskStatusEnum::IN_PROGRESS->value,
            'priority' => TaskPriorityEnum::HIGH->value,
        ]);

        EmployeeTask::query()->create([
            'employee_id' => $employee->id,
            'task_id' => $task1->id,
        ]);

        EmployeeTask::query()->create([
            'employee_id' => $employee->id,
            'task_id' => $task2->id,
        ]);

        $response = $this->getJson("/api/assignments/employee/{$employee->id}");

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(2, $data);
    }

    public function test_when_employee_has_no_assignments_then_it_should_return_empty_list(): void
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response = $this->getJson("/api/assignments/employee/{$employee->id}");

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(0, $data);
    }
}
