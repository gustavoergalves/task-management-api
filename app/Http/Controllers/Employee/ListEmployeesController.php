<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Data\Employee\EmployeeFilterData;
use App\Data\PaginationParamsData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ListEmployeeRequest;
use App\Services\Employee\ListEmployeesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ListEmployeesController extends Controller
{
    public function __construct(private readonly ListEmployeesService $listEmployeesService) {}

    public function __invoke(ListEmployeeRequest $request): JsonResponse
    {
        $employees = $this->listEmployeesService->__invoke(
            filters: EmployeeFilterData::fromRequest($request),
            pagination: PaginationParamsData::fromRequest($request),
        );

        return new JsonResponse($employees, Response::HTTP_OK);
    }
}
