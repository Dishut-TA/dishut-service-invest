<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePenarikanRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nominal_penarikan' => 'required|numeric|min:1',
            'bank_tujuan' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:100',
            'nama_pemilik_rekening' => 'required|string|max:255',
        ];
    }
}
