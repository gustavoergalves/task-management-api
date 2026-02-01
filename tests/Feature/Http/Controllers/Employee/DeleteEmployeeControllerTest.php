<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Employee;

use App\Models\Employee;
use Tests\TestCase;

class DeleteEmployeeControllerTest extends TestCase
{
    public function test_when_employee_exists_then_it_should_delete_successfully(): void
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Engineer',
            'department' => 'Engineering',
        ]);

        $response = $this->deleteJson("/api/employees/{$employee->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
        ]);
    }

    public function test_when_employee_does_not_exist_then_it_should_return_not_found(): void
    {
        $response = $this->deleteJson('/api/employees/999');

        $response->assertNotFound();
    }
}
