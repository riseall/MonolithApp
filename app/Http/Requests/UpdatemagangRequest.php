<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatemagangRequest extends FormRequest
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
            'mahasiswa_id' => 'sometimes',
            'perusahaan_id' => 'sometimes|nullable',
            'periode' => 'sometimes|string',
            'posisi' => 'sometimes|string',
            'dosen_id' => 'sometimes|nullable',
            'laporan_id' => 'sometimes|nullable'
        ];
    }
}
