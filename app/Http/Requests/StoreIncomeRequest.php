<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

public function rules(): array
{
    return [
        'income_date' => 'required|date|before_or_equal:today',
        'source'      => 'required|string|max:255',
        'amount'      => 'required|numeric|min:1|max:999999999',
    ];
}

    public function messages(): array
    {
        return [
            'income_date.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
            'amount.min'                  => 'Nominal minimal Rp 1.',
            'amount.max'                  => 'Nominal terlalu besar.',
        ];
    }
}