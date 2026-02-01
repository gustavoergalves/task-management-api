<?php

declare(strict_types=1);

namespace App\Services\Employee;

use App\Data\Employee\EmployeeData;
use App\Exceptions\EmployeeNotFoundException;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class UpdateEmployeeService
{
    public function __construct(private readonly EmployeeRepositoryInterface $employeeRepository) {}

    /**
     * @throws EmployeeNotFoundException
     */
    public function __invoke(EmployeeData $employeeData): EmployeeData
    {
        $employee = $this->employeeRepository->update($employeeData);

        return EmployeeData::fromModel($employee);
    }
}
