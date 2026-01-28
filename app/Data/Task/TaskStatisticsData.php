<?php

declare(strict_types=1);

namespace App\Data\Task;

use Spatie\LaravelData\Data;

class TaskStatisticsData extends Data
{
    public function __construct(
        public int $totalTasks,
        public TaskByStatusData $byStatus,
        public TaskByPriorityData $byPriority,
    ) {
    }

    public static function fromObject(object $statisticsObject): self {
        return new self(
            totalTasks: $statisticsObject->totalTasks,
            byStatus: TaskByStatusData::fromObject($statisticsObject),
            byPriority: TaskByPriorityData::fromObject($statisticsObject),
        );
    }
}
