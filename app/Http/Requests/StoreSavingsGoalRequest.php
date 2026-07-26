<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSavingsGoalRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'goal_name'      => 'required|string|max:255',
            'target_amount'  => 'required|numeric|min:1|max:999999999',
            'current_amount' => 'nullable|numeric|min:0|max:999999999',
            'target_date'    => 'nullable|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'target_amount.min' => 'Target dana minimal Rp 1.',
            'target_date.after' => 'Tanggal target harus setelah hari ini.',
        ];
    }
}