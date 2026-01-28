<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Data\PaginationParamsData;
use App\Data\Task\TaskData;
use App\Data\Task\TaskFilterData;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListTasksService
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    public function __invoke(TaskFilterData $filters, PaginationParamsData $pagination): LengthAwarePaginator
    {
        $tasks = $this->taskRepository->list(
            filters: $filters,
            pagination: $pagination,
        );

        $tasks->getCollection()->transform(fn(Task $task) => TaskData::fromModel($task));

        return $tasks;
    }
}
