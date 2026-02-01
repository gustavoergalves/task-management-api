<?php

declare(strict_types=1);

namespace App\Services\EmployeeTask;

use App\Data\EmployeeTask\EmployeeTaskData;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;

class AssignTaskService
{
    public function __construct(
        private readonly EmployeeTaskRepositoryInterface $employeeTaskRepository,
        private readonly EmployeeRepositoryInterface $employeeRepository,
        private readonly TaskRepositoryInterface $taskRepository,
    ) {}

    public function __invoke(EmployeeTaskData $data): EmployeeTaskData
    {
        $this->employeeRepository->findById($data->employeeId);
        $this->taskRepository->findById($data->taskId);

        $employeeTask = $this->employeeTaskRepository->assign($data);

        return EmployeeTaskData::fromModel($employeeTask);
    }
}
