<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Data\Task\TaskData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateUpdateTaskRequest;
use App\Services\Task\CreateTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateTaskController extends Controller
{
    public function __construct(private readonly CreateTaskService $service) {}

    public function __invoke(CreateUpdateTaskRequest $request): JsonResponse
    {
        $task = $this->service->__invoke(TaskData::fromRequest($request));

        return new JsonResponse(['data' => $task], Response::HTTP_CREATED);
    }
}
