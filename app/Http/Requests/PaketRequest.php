<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PaketRequest extends FormRequest
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
            'outlet_id' => 'required|exists:outlet,id',
            'jenis' => 'required|in:kiloan,selimut,bed_cover,kaos,lain',
            'nama_paket' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
        ];
    }
}
