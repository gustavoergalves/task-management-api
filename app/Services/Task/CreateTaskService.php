<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Data\Task\TaskData;
use App\Repositories\Contracts\TaskRepositoryInterface;

class CreateTaskService
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    public function __invoke(TaskData $taskData): TaskData
    {
        $task = $this->taskRepository->create($taskData);

        return TaskData::fromModel($task);
    }
}
