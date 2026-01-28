<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Data\Task\TaskData;
use App\Exceptions\TaskNotFoundException;
use App\Repositories\Contracts\TaskRepositoryInterface;

class FindByIdTaskService
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * @throws TaskNotFoundException
     */
    public function __invoke(int $id): TaskData
    {
        $task = $this->taskRepository->findById($id);

        return TaskData::fromModel($task);
    }
}
