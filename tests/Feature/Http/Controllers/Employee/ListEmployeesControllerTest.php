<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Employee;

use App\Models\Employee;
use Tests\TestCase;

class ListEmployeesControllerTest extends TestCase
{
    public function test_when_employees_exist_then_it_should_return_paginated_list(): void
    {
        Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Engineer',
            'department' => 'Engineering',
        ]);

        Employee::query()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'position' => 'Designer',
            'department' => 'Design',
        ]);

        $response = $this->getJson('/api/employees');

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(2, $data);
    }

    public function test_when_filtering_by_department_then_it_should_return_filtered_results(): void
    {
        Employee::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Engineer',
            'department' => 'Engineering',
        ]);

        Employee::query()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'position' => 'Designer',
            'department' => 'Design',
        ]);

        $response = $this->getJson('/api/employees?department=Engineering');

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('John Doe', $data[0]['name']);
    }
}
