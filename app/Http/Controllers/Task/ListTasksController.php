<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Data\PaginationParamsData;
use App\Data\Task\TaskFilterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\ListTaskRequest;
use App\Services\Task\ListTasksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ListTasksController extends Controller
{
    public function __construct(private readonly ListTasksService $listTasksService) {}

    public function __invoke(ListTaskRequest $request): JsonResponse
    {
        $tasks = $this->listTasksService->__invoke(
            filters: TaskFilterData::fromRequest($request),
            pagination: PaginationParamsData::fromRequest($request),
        );

        return new JsonResponse($tasks, Response::HTTP_OK);
    }
}
