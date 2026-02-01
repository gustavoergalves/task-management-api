<?php

declare(strict_types=1);

namespace App\Http\Controllers\EmployeeTask;

use App\Http\Controllers\Controller;
use App\Services\EmployeeTask\ListAssignmentsByEmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ListAssignmentsByEmployeeController extends Controller
{
    public function __construct(private readonly ListAssignmentsByEmployeeService $service) {}

    public function __invoke(int $employee): JsonResponse
    {
        $assignments = $this->service->__invoke($employee);

        return new JsonResponse(['data' => $assignments->toArray()], Response::HTTP_OK);
    }
}
