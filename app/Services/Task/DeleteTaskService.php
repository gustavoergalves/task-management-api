<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Exceptions\TaskNotFoundException;
use App\Repositories\Contracts\TaskRepositoryInterface;

class DeleteTaskService
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository) {}

    /**
     * @throws TaskNotFoundException
     */
    public function __invoke(int $id): void
    {
        $this->taskRepository->delete($id);
    }
}
