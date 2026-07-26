<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'expense_date' => 'required|date|before_or_equal:today',
            'category_id'  => 'required|exists:categories,id',
            'amount'       => 'required|numeric|min:1|max:999999999',
            'note'         => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'expense_date.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
            'category_id.exists'           => 'Kategori tidak valid.',
            'amount.min'                   => 'Nominal minimal Rp 1.',
            'amount.max'                   => 'Nominal terlalu besar.',
        ];
    }
}