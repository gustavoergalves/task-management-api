<?php

declare(strict_types=1);

namespace App\Services\Employee;

use App\Data\Employee\EmployeeData;
use App\Data\Employee\EmployeeFilterData;
use App\Data\PaginationParamsData;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListEmployeesService
{
    public function __construct(private readonly EmployeeRepositoryInterface $employeeRepository) {}

    public function __invoke(EmployeeFilterData $filters, PaginationParamsData $pagination): LengthAwarePaginator
    {
        $employees = $this->employeeRepository->list(
            filters: $filters,
            pagination: $pagination,
        );

        /** @var \Illuminate\Pagination\LengthAwarePaginator $employees */
        $employees->setCollection(
            $employees->getCollection()->map(fn (Employee $employee) => EmployeeData::fromModel($employee))
        );

        return $employees;
    }
}
