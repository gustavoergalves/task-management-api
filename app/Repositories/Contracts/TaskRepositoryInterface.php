<?php

namespace App\Repositories\Contracts;

use App\Data\PaginationParamsData;
use App\Data\Task\TaskData;
use App\Data\Task\TaskFilterData;
use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    public function list(TaskFilterData $filters, PaginationParamsData $pagination): LengthAwarePaginator;

    /**
     * @throws TaskNotFoundException
     */
    public function findById(int $id): Task;

    public function create(TaskData $data): Task;

    /**
     * @throws TaskNotFoundException
     */
    public function update(TaskData $data): Task;

    /**
     * @throws TaskNotFoundException
     */
    public function delete(int $id): void;

    public function getTaskStatistics(): object;
}
