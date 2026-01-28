<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Task;

use App\Data\Task\TaskData;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\Task\CreateTaskService;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateTaskServiceTest extends TestCase
{
    private TaskRepositoryInterface&MockInterface $taskRepository;
    private CreateTaskService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = $this->mock(TaskRepositoryInterface::class);

        $this->service = new CreateTaskService($this->taskRepository);
    }

    public function test_when_it_creates_a_task_then_it_should_return_task_data_successfully(): void
    {
        $taskData = new TaskData(
            id: null,
            title: 'Test Task',
            description: 'Test description',
            status: TaskStatusEnum::PENDING,
            priority: TaskPriorityEnum::MEDIUM,
            dueDate: '2025-01-01',
        );

        $taskModel = new Task([
            'title' => $taskData->title,
            'description' => $taskData->description,
            'status' => $taskData->status,
            'priority' => $taskData->priority,
            'due_date' => $taskData->dueDate,
        ]);
        $taskModel->id = 1;

        $this->taskRepository
            ->shouldReceive('create')
            ->once()
            ->with($taskData)
            ->andReturn($taskModel);

        $result = $this->service->__invoke($taskData);

        $this->assertSame($taskModel->title, $result->title);
        $this->assertSame($taskModel->description, $result->description);
        $this->assertSame($taskModel->status, $result->status);
        $this->assertSame($taskModel->priority, $result->priority);
        $this->assertEquals($taskModel->due_date->format('Y-m-d'), $result->dueDate);
    }
}
