<?php

namespace App\Repositories\Contracts;

use App\Data\EmployeeTask\EmployeeTaskData;
use App\Exceptions\EmployeeTaskNotFoundException;
use App\Models\EmployeeTask;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeTaskRepositoryInterface
{
    public function assign(EmployeeTaskData $data): EmployeeTask;

    /**
     * @throws EmployeeTaskNotFoundException
     */
    public function unassign(int $employeeId, int $taskId): void;

    public function getByEmployee(int $employeeId): Collection;

    public function getByTask(int $taskId): Collection;

    public function findByEmployeeAndTask(int $employeeId, int $taskId): ?EmployeeTask;
}
