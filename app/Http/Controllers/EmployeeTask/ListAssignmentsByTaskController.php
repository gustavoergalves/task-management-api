<?php

declare(strict_types=1);

namespace App\Http\Controllers\EmployeeTask;

use App\Http\Controllers\Controller;
use App\Services\EmployeeTask\ListAssignmentsByTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ListAssignmentsByTaskController extends Controller
{
    public function __construct(private readonly ListAssignmentsByTaskService $service) {}

    public function __invoke(int $task): JsonResponse
    {
        $assignments = $this->service->__invoke($task);

        return new JsonResponse(['data' => $assignments->toArray()], Response::HTTP_OK);
    }
}
