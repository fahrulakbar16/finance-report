<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'villa_id' => ['required', 'exists:villas,id'],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:income,expense'],
            'date' => ['required', 'date'],
            'category_id' => ['nullable', 'integer'],
            'is_recurring' => ['nullable', 'boolean'],
            'frequency' => ['nullable', 'required_if:is_recurring,1', 'in:monthly,weekly,yearly'],
            'end_date' => ['nullable', 'date', 'after_or_equal:date'],
            'is_tanggungan_pemilik' => ['nullable', 'boolean'],
        ];
    }
}
