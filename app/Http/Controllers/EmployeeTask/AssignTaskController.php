<?php

declare(strict_types=1);

namespace App\Http\Controllers\EmployeeTask;

use App\Data\EmployeeTask\EmployeeTaskData;
use App\Exceptions\EmployeeNotFoundException;
use App\Exceptions\TaskNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeTask\AssignTaskRequest;
use App\Services\EmployeeTask\AssignTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AssignTaskController extends Controller
{
    public function __construct(private readonly AssignTaskService $service) {}

    public function __invoke(AssignTaskRequest $request): JsonResponse
    {
        try {
            $assignment = $this->service->__invoke(EmployeeTaskData::fromRequest($request));

            return new JsonResponse(['data' => $assignment], Response::HTTP_CREATED);
        } catch (EmployeeNotFoundException|TaskNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
