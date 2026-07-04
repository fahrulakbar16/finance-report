<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVillaRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
            'persenan_pengelola' => ['required', 'integer', 'min:0', 'max:100'],
            'persenan_pemilik' => ['required', 'integer', 'min:0', 'max:100'],
            'rooms' => ['nullable', 'array'],
            'rooms.*.name' => ['required_with:rooms', 'string', 'max:255'],
            'rooms.*.amount' => ['required_with:rooms', 'integer', 'min:1'],
            'fasilitas' => ['nullable', 'array'],
            'fasilitas.*' => ['exists:fasilitas,id'],
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
