<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMahasiswaRequest extends FormRequest
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
            'foto' => 'sometimes|file',
            'nama' => 'sometimes|string|max:255',
            'nim' => 'sometimes|numeric',
            'kelas' => 'sometimes|string',
            'telepon' => 'sometimes|string',
            'email' => 'sometimes|email',
            'alamat' => 'sometimes|string',
        ];
    }
}