<?php

declare(strict_types=1);

namespace Tests\Unit\Services\EmployeeTask;

use App\Data\EmployeeTask\EmployeeTaskData;
use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\Task;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\EmployeeTask\AssignTaskService;
use Mockery\MockInterface;
use Tests\TestCase;

class AssignTaskServiceTest extends TestCase
{
    private EmployeeTaskRepositoryInterface&MockInterface $employeeTaskRepository;

    private EmployeeRepositoryInterface&MockInterface $employeeRepository;

    private TaskRepositoryInterface&MockInterface $taskRepository;

    private AssignTaskService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeTaskRepository = $this->mock(EmployeeTaskRepositoryInterface::class);
        $this->employeeRepository = $this->mock(EmployeeRepositoryInterface::class);
        $this->taskRepository = $this->mock(TaskRepositoryInterface::class);

        $this->service = new AssignTaskService(
            $this->employeeTaskRepository,
            $this->employeeRepository,
            $this->taskRepository,
        );
    }

    public function test_when_it_assigns_a_task_then_it_should_return_assignment_data_successfully(): void
    {
        $data = new EmployeeTaskData(
            id: null,
            employeeId: 1,
            taskId: 1,
            employee: null,
            task: null,
        );

        $employeeModel = new Employee([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        $employeeModel->id = 1;

        $taskModel = new Task([
            'title' => 'Test Task',
        ]);
        $taskModel->id = 1;

        $employeeTaskModel = new EmployeeTask([
            'employee_id' => 1,
            'task_id' => 1,
        ]);
        $employeeTaskModel->id = 1;

        $this->employeeRepository
            ->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($employeeModel);

        $this->taskRepository
            ->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($taskModel);

        $this->employeeTaskRepository
            ->shouldReceive('assign')
            ->once()
            ->with($data)
            ->andReturn($employeeTaskModel);

        $result = $this->service->__invoke($data);

        $this->assertSame(1, $result->employeeId);
        $this->assertSame(1, $result->taskId);
    }
}
