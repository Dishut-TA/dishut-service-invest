<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanKeuanganRequest extends FormRequest
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
            'program_id' => 'required|uuid|exists:program_investasis,id',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            
            'total_pendapatan' => 'required|array',
            'total_pendapatan.*.tanggal' => 'required|date',
            'total_pendapatan.*.keterangan' => 'required|string',
            'total_pendapatan.*.nominal' => 'required|numeric|min:0',
            'total_pendapatan.*.dokumen' => 'nullable|string',

            'total_pengeluaran' => 'required|array',
            'total_pengeluaran.*.tanggal' => 'required|date',
            'total_pengeluaran.*.keterangan' => 'required|string',
            'total_pengeluaran.*.nominal' => 'required|numeric|min:0',
            'total_pengeluaran.*.dokumen' => 'nullable|string',

            'bukti_nota_url' => 'nullable|string',
            'status' => 'nullable|in:DRAFT,SUBMITTED,REVISED,APPROVED',
        ];
    }
}
