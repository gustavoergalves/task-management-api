<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EmployeeTask;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AssignTaskControllerTest extends TestCase
{
    public function test_when_payload_is_valid_then_it_should_assign_task_to_employee_successfully(): void
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Engineer',
            'department' => 'Engineering',
        ]);

        /** @var Task $task */
        $task = Task::query()->create([
            'title' => 'Test Task',
            'description' => 'Test description',
            'status' => TaskStatusEnum::PENDING->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
            'due_date' => '2025-12-31',
        ]);

        $payload = [
            'employeeId' => $employee->id,
            'taskId' => $task->id,
        ];

        $response = $this->postJson('/api/assignments', $payload);

        $response
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data')
                ->where('data.employeeId', $employee->id)
                ->where('data.taskId', $task->id)
                ->has('data.employee')
                ->has('data.task'),
            );

        $this->assertDatabaseHas('employee_task', [
            'employee_id' => $employee->id,
            'task_id' => $task->id,
        ]);
    }

    public function test_when_employee_does_not_exist_then_it_should_return_not_found(): void
    {
        /** @var Task $task */
        $task = Task::query()->create([
            'title' => 'Test Task',
            'description' => 'Test description',
            'status' => TaskStatusEnum::PENDING->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
        ]);

        $payload = [
            'employeeId' => 999,
            'taskId' => $task->id,
        ];

        $response = $this->postJson('/api/assignments', $payload);

        $response->assertNotFound();
    }

    public function test_when_task_does_not_exist_then_it_should_return_not_found(): void
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $payload = [
            'employeeId' => $employee->id,
            'taskId' => 999,
        ];

        $response = $this->postJson('/api/assignments', $payload);

        $response->assertNotFound();
    }

    public function test_when_payload_is_invalid_then_it_should_return_validation_errors(): void
    {
        $payload = [];

        $response = $this->postJson('/api/assignments', $payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}
