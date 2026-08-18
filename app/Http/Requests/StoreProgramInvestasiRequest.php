<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProgramInvestasiRequest extends FormRequest
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
            'nama_program' => 'required|string|max:255',
            'kategori_usaha' => 'required|string|max:100',
            'target_dana' => 'required|numeric|min:1',
            'persentase_keuntungan' => 'required|numeric|min:0.01|max:100',
            'periode_kontrak_bulan' => 'required|integer|min:1',
            'batas_waktu_pengumpulan' => 'required|date|after:today',
            'deskripsi' => 'required|string',
            
            // Nested arrays validation
            'milestones' => 'required|array|min:1',
            'milestones.*.judul_milestone' => 'required|string|max:255',
            'milestones.*.deskripsi' => 'required|string',
            'milestones.*.target_tanggal' => 'required|date|after:today',
            
            'dokumens' => 'required|array|min:1',
            'dokumens.*.tipe_dokumen' => 'required|in:COVER_IMAGE,PROPOSAL_BISNIS,LEGALITAS,TEMPLATE_PERJANJIAN',
            'dokumens.*.file_url' => 'required|string', // Asumsi menggunakan string/URL
        ];
    }
}
