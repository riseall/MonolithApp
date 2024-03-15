<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoremagangRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'mahasiswa_id' => 'required',
            'perusahaan_id' => 'nullable',
            'periode' => 'string',
            'posisi' => 'string',
            'dosen_id' => 'nullable',
            'laporan_id' => 'nullable'
        ];
    }
}
