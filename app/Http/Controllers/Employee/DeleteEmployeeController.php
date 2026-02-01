<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Exceptions\EmployeeNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Employee\DeleteEmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteEmployeeController extends Controller
{
    public function __construct(private readonly DeleteEmployeeService $service) {}

    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->service->__invoke($id);

            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        } catch (EmployeeNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
