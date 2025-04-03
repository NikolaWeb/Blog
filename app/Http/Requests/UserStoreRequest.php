<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserStoreRequest extends FormRequest
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
        $config_user_types = config('blog.config_user_types');
        // Get all request inputs
        $rules = [
            'name' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'firstname' => 'nullable|string',
            'lastname' => 'nullable|string',
            'type' =>  ['required', 'string', 'in:' . implode(',', $config_user_types)],
        ];

        return $rules;
    }

    /**
     * @param Validator $validator
     *
     * @return void
     */
    public function failedValidation(Validator $validator): JsonResponse
    {
        abort(response()->json(["errors" => $validator->errors()], Response::HTTP_I_AM_A_TEAPOT));
    }
}
