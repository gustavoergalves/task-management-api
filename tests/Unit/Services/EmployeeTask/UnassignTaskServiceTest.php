<?php

declare(strict_types=1);

namespace Tests\Unit\Services\EmployeeTask;

use App\Exceptions\EmployeeTaskNotFoundException;
use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;
use App\Services\EmployeeTask\UnassignTaskService;
use Mockery\MockInterface;
use Tests\TestCase;

class UnassignTaskServiceTest extends TestCase
{
    private EmployeeTaskRepositoryInterface&MockInterface $employeeTaskRepository;

    private UnassignTaskService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeTaskRepository = $this->mock(EmployeeTaskRepositoryInterface::class);

        $this->service = new UnassignTaskService($this->employeeTaskRepository);
    }

    public function test_when_it_unassigns_a_task_then_it_should_succeed(): void
    {
        $this->employeeTaskRepository
            ->shouldReceive('unassign')
            ->once()
            ->with(1, 1);

        $this->service->__invoke(1, 1);

        $this->assertTrue(true);
    }

    public function test_when_assignment_does_not_exist_then_it_should_throw_exception(): void
    {
        $this->employeeTaskRepository
            ->shouldReceive('unassign')
            ->once()
            ->with(999, 999)
            ->andThrow(new EmployeeTaskNotFoundException('Assignment not found'));

        $this->expectException(EmployeeTaskNotFoundException::class);

        $this->service->__invoke(999, 999);
    }
}
