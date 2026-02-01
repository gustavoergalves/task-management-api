<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Employee;

use App\Data\Employee\EmployeeData;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Employee\UpdateEmployeeService;
use Mockery\MockInterface;
use Tests\TestCase;

class UpdateEmployeeServiceTest extends TestCase
{
    private EmployeeRepositoryInterface&MockInterface $employeeRepository;

    private UpdateEmployeeService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeRepository = $this->mock(EmployeeRepositoryInterface::class);

        $this->service = new UpdateEmployeeService($this->employeeRepository);
    }

    public function test_when_it_updates_an_employee_then_it_should_return_updated_employee_data(): void
    {
        $employeeData = new EmployeeData(
            id: 1,
            name: 'John Updated',
            email: 'john.updated@example.com',
            position: 'Senior Engineer',
            department: 'Engineering',
        );

        $employeeModel = new Employee([
            'name' => $employeeData->name,
            'email' => $employeeData->email,
            'position' => $employeeData->position,
            'department' => $employeeData->department,
        ]);
        $employeeModel->id = 1;

        $this->employeeRepository
            ->shouldReceive('update')
            ->once()
            ->with($employeeData)
            ->andReturn($employeeModel);

        $result = $this->service->__invoke($employeeData);

        $this->assertSame('John Updated', $result->name);
        $this->assertSame('john.updated@example.com', $result->email);
        $this->assertSame('Senior Engineer', $result->position);
    }
}
