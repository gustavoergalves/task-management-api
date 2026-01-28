<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Exceptions\TaskNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Task\DeleteTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteTaskController extends Controller
{
    public function __construct(private readonly DeleteTaskService $service)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->service->__invoke($id);
            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        } catch (TaskNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
