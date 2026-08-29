<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanProyekRequest extends FormRequest
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
            'milestone_id' => 'nullable|uuid|exists:program_milestones,id',
            'deskripsi_kemajuan' => 'required|string',
            'dana_terpakai' => 'required|numeric|min:0',
            
            'dokumens' => 'required|array|min:1',
            'dokumens.*.file_url' => 'required|string',
        ];
    }
}
