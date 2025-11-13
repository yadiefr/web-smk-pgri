<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9@._-]+$/', // Only allow alphanumeric, @, ., _, - characters
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
            'remember' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Email/NIS/NIP wajib diisi',
            'username.regex' => 'Format Email/NIS/NIP tidak valid',
            'password.required' => 'Password wajib diisi',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => $this->sanitizeInput($this->username),
        ]);
    }

    /**
     * Sanitize input to prevent malicious content
     */
    private function sanitizeInput(?string $input): ?string
    {
        if (!$input) {
            return $input;
        }

        // Remove potentially dangerous characters and patterns
        $input = strip_tags($input);
        $input = trim($input);
        
        // Remove SQL injection patterns
        $sqlPatterns = [
            '/(\s*(union|select|insert|update|delete|drop|create|alter|exec|execute)\s+)/i',
            '/(\s*(--))/i', // SQL comments
            '/(\s*(\/\*)|(.*\*\/))/i', // SQL block comments
            '/(\s*[\'";])/i', // Dangerous quotes and semicolons at boundaries
        ];
        
        foreach ($sqlPatterns as $pattern) {
            $input = preg_replace($pattern, '', $input);
        }
        
        return $input;
    }
}
