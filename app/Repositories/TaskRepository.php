<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\PaginationParamsData;
use App\Data\Task\TaskData;
use App\Data\Task\TaskFilterData;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TaskRepository implements TaskRepositoryInterface
{
    public function list(TaskFilterData $filters, PaginationParamsData $pagination): LengthAwarePaginator
    {
        $query = Task::query();

        $query = $this->applyFilters($query, $filters);

        return $query
            ->orderBy($pagination->sortBy, $pagination->sortDirection)
            ->paginate(
                perPage: $pagination->itemsPerPage,
                page: $pagination->currentPage,
            );
    }

    /**
     * @throws TaskNotFoundException
     */
    public function findById(int $id): Task
    {
        /** @var Task|null $task */
        $task = Task::query()->find($id);

        if (! $task) {
            throw new TaskNotFoundException('Task not found');
        }

        return $task;
    }

    public function create(TaskData $data): Task
    {
        /** @var Task $task */
        $task = Task::query()->create([
            'title' => $data->title,
            'description' => $data->description,
            'status' => $data->status,
            'priority' => $data->priority,
            'due_date' => $data->dueDate,
        ]);

        return $task;
    }

    /**
     * @throws TaskNotFoundException
     */
    public function update(TaskData $data): Task
    {
        $task = $this->findById($data->id);

        $task->update([
            'title' => $data->title,
            'description' => $data->description,
            'status' => $data->status,
            'priority' => $data->priority,
            'due_date' => $data->dueDate,
        ]);

        return $task;
    }

    /**
     * @throws TaskNotFoundException
     */
    public function delete(int $id): void
    {
        $task = $this->findById($id);

        $task->delete();
    }

    public function getTaskStatistics(): object
    {
        return DB::table('tasks')
            ->selectRaw(
                '
                    COUNT(*) AS "totalTasks",
                    COUNT(*) FILTER (WHERE status = ?) AS pending,
                    COUNT(*) FILTER (WHERE status = ?) AS in_progress,
                    COUNT(*) FILTER (WHERE status = ?) AS completed,
                    COUNT(*) FILTER (WHERE priority = ?) AS low,
                    COUNT(*) FILTER (WHERE priority = ?) AS medium,
                    COUNT(*) FILTER (WHERE priority = ?) AS high',
                [
                    TaskStatusEnum::PENDING->value,
                    TaskStatusEnum::IN_PROGRESS->value,
                    TaskStatusEnum::COMPLETED->value,
                    TaskPriorityEnum::LOW->value,
                    TaskPriorityEnum::MEDIUM->value,
                    TaskPriorityEnum::HIGH->value,
                ],
            )
            ->first();
    }

    private function applyFilters(Builder $query, TaskFilterData $filters): Builder
    {
        if ($filters->status) {
            $query->where('status', $filters->status);
        }

        if ($filters->priority) {
            $query->where('priority', $filters->priority);
        }

        return $query;
    }
}
