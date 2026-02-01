<?php

declare(strict_types=1);

namespace App\Services\EmployeeTask;

use App\Exceptions\EmployeeTaskNotFoundException;
use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;

class UnassignTaskService
{
    public function __construct(private readonly EmployeeTaskRepositoryInterface $employeeTaskRepository) {}

    /**
     * @throws EmployeeTaskNotFoundException
     */
    public function __invoke(int $employeeId, int $taskId): void
    {
        $this->employeeTaskRepository->unassign($employeeId, $taskId);
    }
}
