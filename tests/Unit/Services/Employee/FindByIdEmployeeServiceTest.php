<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Employee;

use App\Exceptions\EmployeeNotFoundException;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Employee\FindByIdEmployeeService;
use Mockery\MockInterface;
use Tests\TestCase;

class FindByIdEmployeeServiceTest extends TestCase
{
    private EmployeeRepositoryInterface&MockInterface $employeeRepository;

    private FindByIdEmployeeService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeRepository = $this->mock(EmployeeRepositoryInterface::class);

        $this->service = new FindByIdEmployeeService($this->employeeRepository);
    }

    public function test_when_employee_exists_then_it_should_return_employee_data(): void
    {
        $employeeModel = new Employee([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Engineer',
            'department' => 'Engineering',
        ]);
        $employeeModel->id = 1;

        $this->employeeRepository
            ->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($employeeModel);

        $result = $this->service->__invoke(1);

        $this->assertSame('John Doe', $result->name);
        $this->assertSame('john@example.com', $result->email);
    }

    public function test_when_employee_does_not_exist_then_it_should_throw_exception(): void
    {
        $this->employeeRepository
            ->shouldReceive('findById')
            ->once()
            ->with(999)
            ->andThrow(new EmployeeNotFoundException('Employee not found'));

        $this->expectException(EmployeeNotFoundException::class);

        $this->service->__invoke(999);
    }
}
