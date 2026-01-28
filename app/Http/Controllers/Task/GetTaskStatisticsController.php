<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Services\Task\GetTaskStatisticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GetTaskStatisticsController extends Controller
{
    public function __construct(private readonly GetTaskStatisticsService $service)
    {
    }

    public function __invoke(): JsonResponse
    {
        $taskStatistics = $this->service->__invoke();

        return new JsonResponse(['data' => $taskStatistics], Response::HTTP_OK);
    }
}
