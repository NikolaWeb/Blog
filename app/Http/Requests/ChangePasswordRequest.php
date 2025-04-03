<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ];
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
