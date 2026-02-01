<?php

declare(strict_types=1);

namespace App\Services\EmployeeTask;

use App\Data\EmployeeTask\EmployeeTaskData;
use App\Models\EmployeeTask;
use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;
use Illuminate\Support\Collection;

class ListAssignmentsByTaskService
{
    public function __construct(private readonly EmployeeTaskRepositoryInterface $employeeTaskRepository) {}

    public function __invoke(int $taskId): Collection
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, EmployeeTask> $assignments */
        $assignments = $this->employeeTaskRepository->getByTask($taskId);

        return $assignments->map(fn (EmployeeTask $et) => EmployeeTaskData::fromModel($et));
    }
}
