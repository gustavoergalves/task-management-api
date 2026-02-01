<?php

namespace App\Repositories\Contracts;

use App\Data\Employee\EmployeeData;
use App\Data\Employee\EmployeeFilterData;
use App\Data\PaginationParamsData;
use App\Exceptions\EmployeeNotFoundException;
use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EmployeeRepositoryInterface
{
    public function list(EmployeeFilterData $filters, PaginationParamsData $pagination): LengthAwarePaginator;

    /**
     * @throws EmployeeNotFoundException
     */
    public function findById(int $id): Employee;

    public function create(EmployeeData $data): Employee;

    /**
     * @throws EmployeeNotFoundException
     */
    public function update(EmployeeData $data): Employee;

    /**
     * @throws EmployeeNotFoundException
     */
    public function delete(int $id): void;
}
