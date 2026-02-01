<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Employee;

use App\Data\Employee\EmployeeFilterData;
use App\Data\PaginationParamsData;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Employee\ListEmployeesService;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery\MockInterface;
use Tests\TestCase;

class ListEmployeesServiceTest extends TestCase
{
    private EmployeeRepositoryInterface&MockInterface $employeeRepository;

    private ListEmployeesService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeRepository = $this->mock(EmployeeRepositoryInterface::class);

        $this->service = new ListEmployeesService($this->employeeRepository);
    }

    public function test_when_listing_employees_then_it_should_return_paginated_employee_data(): void
    {
        $filters = new EmployeeFilterData(department: null, name: null);
        $pagination = new PaginationParamsData;

        $employeeModel = new Employee([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Engineer',
            'department' => 'Engineering',
        ]);
        $employeeModel->id = 1;

        $paginator = new LengthAwarePaginator(
            items: collect([$employeeModel]),
            total: 1,
            perPage: 10,
            currentPage: 1,
        );

        $this->employeeRepository
            ->shouldReceive('list')
            ->once()
            ->with($filters, $pagination)
            ->andReturn($paginator);

        $result = $this->service->__invoke($filters, $pagination);

        $this->assertCount(1, $result->items());
        $this->assertSame('John Doe', $result->items()[0]->name);
    }
}
