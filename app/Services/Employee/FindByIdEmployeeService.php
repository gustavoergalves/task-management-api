<?php

declare(strict_types=1);

namespace App\Services\Employee;

use App\Data\Employee\EmployeeData;
use App\Exceptions\EmployeeNotFoundException;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class FindByIdEmployeeService
{
    public function __construct(private readonly EmployeeRepositoryInterface $employeeRepository) {}

    /**
     * @throws EmployeeNotFoundException
     */
    public function __invoke(int $id): EmployeeData
    {
        $employee = $this->employeeRepository->findById($id);

        return EmployeeData::fromModel($employee);
    }
}
