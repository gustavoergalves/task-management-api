<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Data\Employee\EmployeeData;
use App\Exceptions\EmployeeNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\CreateUpdateEmployeeRequest;
use App\Services\Employee\UpdateEmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateEmployeeController extends Controller
{
    public function __construct(private readonly UpdateEmployeeService $service) {}

    public function __invoke(int $id, CreateUpdateEmployeeRequest $request): JsonResponse
    {
        try {
            $employeeData = $this->service->__invoke(EmployeeData::fromRequest($request, $id));

            return new JsonResponse(['data' => $employeeData], Response::HTTP_OK);
        } catch (EmployeeNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
