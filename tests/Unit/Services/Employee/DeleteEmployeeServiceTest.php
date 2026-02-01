<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Employee;

use App\Exceptions\EmployeeNotFoundException;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Employee\DeleteEmployeeService;
use Mockery\MockInterface;
use Tests\TestCase;

class DeleteEmployeeServiceTest extends TestCase
{
    private EmployeeRepositoryInterface&MockInterface $employeeRepository;

    private DeleteEmployeeService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeRepository = $this->mock(EmployeeRepositoryInterface::class);

        $this->service = new DeleteEmployeeService($this->employeeRepository);
    }

    public function test_when_it_deletes_an_employee_then_it_should_succeed(): void
    {
        $this->employeeRepository
            ->shouldReceive('delete')
            ->once()
            ->with(1);

        $this->service->__invoke(1);

        $this->assertTrue(true);
    }

    public function test_when_employee_does_not_exist_then_it_should_throw_exception(): void
    {
        $this->employeeRepository
            ->shouldReceive('delete')
            ->once()
            ->with(999)
            ->andThrow(new EmployeeNotFoundException('Employee not found'));

        $this->expectException(EmployeeNotFoundException::class);

        $this->service->__invoke(999);
    }
}
