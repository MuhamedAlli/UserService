<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . auth()->id(),
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The name must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
        {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                response()->json([
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422)
            );  
        }
}
