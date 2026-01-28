<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Data\PaginationParamsData;
use App\Data\Task\TaskData;
use App\Data\Task\TaskFilterData;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListTasksService
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository) {}

    public function __invoke(TaskFilterData $filters, PaginationParamsData $pagination): LengthAwarePaginator
    {
        $tasks = $this->taskRepository->list(
            filters: $filters,
            pagination: $pagination,
        );

        /** @var \Illuminate\Pagination\LengthAwarePaginator $tasks */
        $tasks->setCollection(
            $tasks->getCollection()->map(fn (Task $task) => TaskData::fromModel($task))
        );

        return $tasks;
    }
}
