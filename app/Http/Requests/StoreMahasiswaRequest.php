<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMahasiswaRequest extends FormRequest
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
            'foto' => 'file|nullable|mimes:jpg,png,pdf|max:2048',
            'nama' => 'required|string|max:255',
            'nim' => 'required',
            'kelas' => 'required',
            'telepon' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
        ];
    }
}