<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsenMasukRequest extends FormRequest
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
            'mahasiswa_id' => 'required|exists:users,id',
            'foto' => 'required|file|mimes:jpg,png,pdf|max:10000',
            'hari' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'lokasi' => 'required'
        ];
    }
}
