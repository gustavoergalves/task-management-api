<?php

declare(strict_types=1);

namespace App\Data\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EmployeeFilterData
{
    public function __construct(
        public ?string $department,
        public ?string $name,
    ) {}

    public static function fromRequest(FormRequest|Request $request): self
    {
        return new self(
            department: $request->query('department'),
            name: $request->query('name'),
        );
    }
}
