<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Data\Employee\EmployeeData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\CreateUpdateEmployeeRequest;
use App\Services\Employee\CreateEmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateEmployeeController extends Controller
{
    public function __construct(private readonly CreateEmployeeService $service) {}

    public function __invoke(CreateUpdateEmployeeRequest $request): JsonResponse
    {
        $employee = $this->service->__invoke(EmployeeData::fromRequest($request));

        return new JsonResponse(['data' => $employee], Response::HTTP_CREATED);
    }
}
