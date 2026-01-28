<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Data\Task\TaskStatisticsData;
use App\Repositories\Contracts\TaskRepositoryInterface;

class GetTaskStatisticsService
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    public function __invoke(): TaskStatisticsData
    {
        $statisticsObject = $this->taskRepository->getTaskStatistics();

        return TaskStatisticsData::fromObject($statisticsObject);
    }
}
