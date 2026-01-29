<?php

declare(strict_types=1);

namespace App\Data\Task;

use Spatie\LaravelData\Data;

class TaskByStatusData extends Data
{
    public function __construct(
        public int $pending,
        public int $in_progress,
        public int $completed,
    ) {}

    public static function fromObject(object $statisticsObject): self
    {
        return new self(
            pending: $statisticsObject->pending,
            in_progress: $statisticsObject->in_progress,
            completed: $statisticsObject->completed,
        );
    }
}
