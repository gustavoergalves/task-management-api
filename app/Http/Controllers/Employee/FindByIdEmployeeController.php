<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Exceptions\EmployeeNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Employee\FindByIdEmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FindByIdEmployeeController extends Controller
{
    public function __construct(private readonly FindByIdEmployeeService $service) {}

    public function __invoke(int $id): JsonResponse
    {
        try {
            $employeeData = $this->service->__invoke($id);

            return new JsonResponse(['data' => $employeeData], Response::HTTP_OK);
        } catch (EmployeeNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
