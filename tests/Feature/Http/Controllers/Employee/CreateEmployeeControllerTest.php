<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Employee;

use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateEmployeeControllerTest extends TestCase
{
    public function test_when_payload_is_valid_then_it_should_create_an_employee_successfully(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'position' => 'Software Engineer',
            'department' => 'Engineering',
        ];

        $response = $this->postJson('/api/employees', $payload);
        $response
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data')
                ->where('data.name', $payload['name'])
                ->where('data.email', $payload['email'])
                ->where('data.position', $payload['position'])
                ->where('data.department', $payload['department']),
            );

        $this->assertDatabaseHas('employees', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'position' => 'Software Engineer',
            'department' => 'Engineering',
        ]);
    }

    public function test_when_payload_is_invalid_then_it_should_return_validation_errors(): void
    {
        $payload = [
            'position' => 'Software Engineer',
        ];

        $response = $this->postJson('/api/employees', $payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $errorDetails = $response->json()['error']['details'];

        $this->assertArrayHasKey('name', $errorDetails);
        $this->assertArrayHasKey('email', $errorDetails);
    }

    public function test_when_email_is_duplicate_then_it_should_return_validation_error(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'position' => 'Software Engineer',
            'department' => 'Engineering',
        ];

        $this->postJson('/api/employees', $payload)->assertCreated();

        $response = $this->postJson('/api/employees', $payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $errorDetails = $response->json()['error']['details'];

        $this->assertArrayHasKey('email', $errorDetails);
    }
}
