<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVillaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pemilik_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
            'persenan_pengelola' => ['required', 'integer', 'min:0', 'max:100'],
            'persenan_pemilik' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('persenan_pengelola')) {
            $this->merge([
                'persenan_pemilik' => 100 - (int) $this->persenan_pengelola,
            ]);
        }
    }
}
