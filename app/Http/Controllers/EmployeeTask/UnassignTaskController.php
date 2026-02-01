<?php

declare(strict_types=1);

namespace App\Http\Controllers\EmployeeTask;

use App\Exceptions\EmployeeTaskNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\EmployeeTask\UnassignTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UnassignTaskController extends Controller
{
    public function __construct(private readonly UnassignTaskService $service) {}

    public function __invoke(int $employee, int $task): JsonResponse
    {
        try {
            $this->service->__invoke($employee, $task);

            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        } catch (EmployeeTaskNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
