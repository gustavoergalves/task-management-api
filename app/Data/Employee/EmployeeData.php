<?php

declare(strict_types=1);

namespace App\Data\Employee;

use App\Http\Requests\Employee\CreateUpdateEmployeeRequest;
use App\Models\Employee;
use Spatie\LaravelData\Data;

class EmployeeData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $position,
        public ?string $department,
    ) {}

    public static function fromModel(Employee $employee): self
    {
        return new self(
            id: $employee->id,
            name: $employee->name,
            email: $employee->email,
            position: $employee->position,
            department: $employee->department,
        );
    }

    public static function fromRequest(CreateUpdateEmployeeRequest $request, ?int $id = null): self
    {
        return new self(
            id: $id,
            name: $request->input('name'),
            email: $request->input('email'),
            position: $request->input('position'),
            department: $request->input('department'),
        );
    }
}
