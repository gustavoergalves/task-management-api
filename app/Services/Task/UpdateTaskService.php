<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Data\Task\TaskData;
use App\Exceptions\TaskNotFoundException;
use App\Repositories\Contracts\TaskRepositoryInterface;

class UpdateTaskService
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * @throws TaskNotFoundException
     */
    public function __invoke(TaskData $taskData): TaskData
    {
        $task = $this->taskRepository->update($taskData);

        return TaskData::fromModel($task);
    }
}
