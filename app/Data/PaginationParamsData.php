<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class PaginationParamsData extends Data
{
    public function __construct(
        public int $itemsPerPage = 10,
        public int $currentPage = 1,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'asc',
    ) {}

    public static function fromRequest(FormRequest|Request $request): self
    {
        return new self(
            itemsPerPage: (int) $request->query('itemsPerPage', 10),
            currentPage: (int) $request->query('page', 1),
            sortBy: $request->query('sortBy', 'created_at'),
            sortDirection: $request->query('sortDirection', 'asc'),
        );
    }
}
