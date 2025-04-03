<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserUpdateRequest extends FormRequest
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
        $userId = (int) $this->route('id');
        $rules = [
            'name' =>[
                'required',
                'string',
                Rule::unique('users')->ignore($userId), // Ignoriše trenutnog korisnika po ID-u
            ],
            'password' => 'nullable|string|min:8',
            'firstname' => 'required|string|min:8',
            'lastname' => 'required|string|min:8',
            'type' => ['required', 'string', 'in:'.implode(',', config('blog.config_user_types'))],
            'active' => 'required|integer',
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
