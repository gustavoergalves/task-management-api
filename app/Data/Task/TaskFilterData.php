<?php

declare(strict_types=1);

namespace App\Data\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TaskFilterData
{
    public function __construct(
        public ?string $status,
        public ?string $priority,
    ) {}

    public static function fromRequest(FormRequest|Request $request): self
    {
        return new self(
            status: $request->query('status'),
            priority: $request->query('priority'),
        );
    }
}
