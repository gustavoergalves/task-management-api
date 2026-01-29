<?php

declare(strict_types=1);

namespace App\Data\Task;

use Spatie\LaravelData\Data;

class TaskByPriorityData extends Data
{
    public function __construct(
        public int $low,
        public int $medium,
        public int $high,
    ) {}

    public static function fromObject(object $statisticsObject): self
    {
        return new self(
            low: $statisticsObject->low,
            medium: $statisticsObject->medium,
            high: $statisticsObject->high,
        );
    }
}
