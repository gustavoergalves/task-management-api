<?php

declare(strict_types=1);

namespace Tests\Unit\Services\EmployeeTask;

use App\Models\EmployeeTask;
use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;
use App\Services\EmployeeTask\ListAssignmentsByTaskService;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class ListAssignmentsByTaskServiceTest extends TestCase
{
    private EmployeeTaskRepositoryInterface&MockInterface $employeeTaskRepository;

    private ListAssignmentsByTaskService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeTaskRepository = $this->mock(EmployeeTaskRepositoryInterface::class);

        $this->service = new ListAssignmentsByTaskService($this->employeeTaskRepository);
    }

    public function test_when_task_has_assignments_then_it_should_return_collection(): void
    {
        $employeeTaskModel = new EmployeeTask([
            'employee_id' => 1,
            'task_id' => 1,
        ]);
        $employeeTaskModel->id = 1;

        $collection = new Collection([$employeeTaskModel]);

        $this->employeeTaskRepository
            ->shouldReceive('getByTask')
            ->once()
            ->with(1)
            ->andReturn($collection);

        $result = $this->service->__invoke(1);

        $this->assertCount(1, $result);
        $this->assertSame(1, $result->first()->taskId);
    }

    public function test_when_task_has_no_assignments_then_it_should_return_empty_collection(): void
    {
        $this->employeeTaskRepository
            ->shouldReceive('getByTask')
            ->once()
            ->with(1)
            ->andReturn(new Collection);

        $result = $this->service->__invoke(1);

        $this->assertCount(0, $result);
    }
}
