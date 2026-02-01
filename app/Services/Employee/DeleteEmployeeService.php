<?php

declare(strict_types=1);

namespace App\Services\Employee;

use App\Exceptions\EmployeeNotFoundException;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class DeleteEmployeeService
{
    public function __construct(private readonly EmployeeRepositoryInterface $employeeRepository) {}

    /**
     * @throws EmployeeNotFoundException
     */
    public function __invoke(int $id): void
    {
        $this->employeeRepository->delete($id);
    }
}
