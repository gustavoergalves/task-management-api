<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Task;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateTaskControllerTest extends TestCase
{
    public function test_when_payload_is_valid_then_it_should_create_a_task_successfully(): void
    {
        $payload = [
            'title' => 'Test Task',
            'description' => 'Test description',
            'status' => TaskStatusEnum::PENDING->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
            'dueDate' => '2025-01-01',
        ];

        $response = $this->postJson('/api/tasks', $payload);
        $response
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data')
                ->where('data.title', $payload['title'])
                ->where('data.description', $payload['description'])
                ->where('data.status', $payload['status'])
                ->where('data.priority', $payload['priority'])
                ->where('data.dueDate', $payload['dueDate']),
            );

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'Test description',
            'status' => 'pending',
            'priority' => 'medium',
            'due_date' => '2025-01-01 00:00:00',
        ]);
    }

    public function test_when_payload_is_invalid_then_it_should_return_validation_errors(): void
    {
        $payload = [
            'description' => 'Test description',
            'priority' => 'invalid-priority',
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $errorDetails = $response->json()['error']['details'];

        $this->assertArrayHasKey('title', $errorDetails);
        $this->assertArrayHasKey('status', $errorDetails);
        $this->assertArrayHasKey('priority', $errorDetails);
    }
}
