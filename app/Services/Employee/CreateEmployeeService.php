<?php

declare(strict_types=1);

namespace App\Services\Employee;

use App\Data\Employee\EmployeeData;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class CreateEmployeeService
{
    public function __construct(private readonly EmployeeRepositoryInterface $employeeRepository) {}

    public function __invoke(EmployeeData $employeeData): EmployeeData
    {
        $employee = $this->employeeRepository->create($employeeData);

        return EmployeeData::fromModel($employee);
    }
}
