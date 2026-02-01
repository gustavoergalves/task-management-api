<?php

declare(strict_types=1);

namespace App\Services\EmployeeTask;

use App\Data\EmployeeTask\EmployeeTaskData;
use App\Models\EmployeeTask;
use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;
use Illuminate\Support\Collection;

class ListAssignmentsByEmployeeService
{
    public function __construct(private readonly EmployeeTaskRepositoryInterface $employeeTaskRepository) {}

    public function __invoke(int $employeeId): Collection
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, EmployeeTask> $assignments */
        $assignments = $this->employeeTaskRepository->getByEmployee($employeeId);

        return $assignments->map(fn (EmployeeTask $et) => EmployeeTaskData::fromModel($et));
    }
}
