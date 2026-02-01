<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Employee;

use App\Models\Employee;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateEmployeeControllerTest extends TestCase
{
    public function test_when_payload_is_valid_then_it_should_update_employee_successfully(): void
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Engineer',
            'department' => 'Engineering',
        ]);

        $payload = [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com',
            'position' => 'Senior Engineer',
            'department' => 'Engineering',
        ];

        $response = $this->patchJson("/api/employees/{$employee->id}", $payload);

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data')
                ->where('data.name', 'John Updated')
                ->where('data.email', 'john.updated@example.com')
                ->where('data.position', 'Senior Engineer'),
            );

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'John Updated',
            'email' => 'john.updated@example.com',
        ]);
    }

    public function test_when_employee_does_not_exist_then_it_should_return_not_found(): void
    {
        $payload = [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com',
        ];

        $response = $this->patchJson('/api/employees/999', $payload);

        $response->assertNotFound();
    }
}
