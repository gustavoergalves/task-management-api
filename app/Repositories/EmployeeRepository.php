<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\Employee\EmployeeData;
use App\Data\Employee\EmployeeFilterData;
use App\Data\PaginationParamsData;
use App\Exceptions\EmployeeNotFoundException;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function list(EmployeeFilterData $filters, PaginationParamsData $pagination): LengthAwarePaginator
    {
        $query = Employee::query();

        $query = $this->applyFilters($query, $filters);

        return $query
            ->orderBy($pagination->sortBy, $pagination->sortDirection)
            ->paginate(
                perPage: $pagination->itemsPerPage,
                page: $pagination->currentPage,
            );
    }

    /**
     * @throws EmployeeNotFoundException
     */
    public function findById(int $id): Employee
    {
        /** @var Employee|null $employee */
        $employee = Employee::query()->find($id);

        if (! $employee) {
            throw new EmployeeNotFoundException('Employee not found');
        }

        return $employee;
    }

    public function create(EmployeeData $data): Employee
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'position' => $data->position,
            'department' => $data->department,
        ]);

        return $employee;
    }

    /**
     * @throws EmployeeNotFoundException
     */
    public function update(EmployeeData $data): Employee
    {
        $employee = $this->findById($data->id);

        $employee->update([
            'name' => $data->name,
            'email' => $data->email,
            'position' => $data->position,
            'department' => $data->department,
        ]);

        return $employee;
    }

    /**
     * @throws EmployeeNotFoundException
     */
    public function delete(int $id): void
    {
        $employee = $this->findById($id);

        $employee->delete();
    }

    private function applyFilters(Builder $query, EmployeeFilterData $filters): Builder
    {
        if ($filters->department) {
            $query->where('department', $filters->department);
        }

        if ($filters->name) {
            $query->where('name', 'like', '%'.$filters->name.'%');
        }

        return $query;
    }
}
