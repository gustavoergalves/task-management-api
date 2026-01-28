<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Data\Task\TaskData;
use App\Exceptions\TaskNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateUpdateTaskRequest;
use App\Services\Task\UpdateTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateTaskController extends Controller
{
    public function __construct(private readonly UpdateTaskService $service)
    {
    }

    public function __invoke(int $id, CreateUpdateTaskRequest $request): JsonResponse
    {
        try {
            $taxData = $this->service->__invoke(TaskData::fromRequest($request, $id));
            return new JsonResponse(['data' => $taxData], Response::HTTP_OK);
        } catch (TaskNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
