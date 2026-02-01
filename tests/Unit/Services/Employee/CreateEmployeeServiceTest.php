<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Employee;

use App\Data\Employee\EmployeeData;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Employee\CreateEmployeeService;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateEmployeeServiceTest extends TestCase
{
    private EmployeeRepositoryInterface&MockInterface $employeeRepository;

    private CreateEmployeeService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeRepository = $this->mock(EmployeeRepositoryInterface::class);

        $this->service = new CreateEmployeeService($this->employeeRepository);
    }

    public function test_when_it_creates_an_employee_then_it_should_return_employee_data_successfully(): void
    {
        $employeeData = new EmployeeData(
            id: null,
            name: 'John Doe',
            email: 'john@example.com',
            position: 'Engineer',
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
            ->shouldReceive('create')
            ->once()
            ->with($employeeData)
            ->andReturn($employeeModel);

        $result = $this->service->__invoke($employeeData);

        $this->assertSame($employeeModel->name, $result->name);
        $this->assertSame($employeeModel->email, $result->email);
        $this->assertSame($employeeModel->position, $result->position);
        $this->assertSame($employeeModel->department, $result->department);
    }
}
