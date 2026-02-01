<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class ListEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department' => ['nullable', 'string', 'max:100'],
            'name' => ['nullable', 'string', 'max:100'],
        ];
    }
}
