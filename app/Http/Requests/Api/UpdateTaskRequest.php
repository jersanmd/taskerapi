<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'required',
                'string',
            ]
        ];
    }

    public function failedValidation(Validator $validator) {
        $errors = $validator -> errors();

        $response = response() -> json([
            'message' => $errors -> messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
