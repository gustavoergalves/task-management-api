<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Employee;

use App\Models\Employee;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FindByIdEmployeeControllerTest extends TestCase
{
    public function test_when_employee_exists_then_it_should_return_employee_data(): void
    {
        /** @var Employee $employee */
        $employee = Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Engineer',
            'department' => 'Engineering',
        ]);

        $response = $this->getJson("/api/employees/{$employee->id}");

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data')
                ->where('data.name', 'John Doe')
                ->where('data.email', 'john@example.com')
                ->where('data.position', 'Engineer')
                ->where('data.department', 'Engineering'),
            );
    }

    public function test_when_employee_does_not_exist_then_it_should_return_not_found(): void
    {
        $response = $this->getJson('/api/employees/999');

        $response->assertNotFound();
        $response->assertJson(['error' => 'Employee not found']);
    }
}
