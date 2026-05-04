<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
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
            'member_id' => 'required|exists:member,id',
            'biaya_tambahan' => 'nullable|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'pajak' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.paket_id' => 'required|exists:paket,id',
            'items.*.qty' => 'required|numeric|min:1',
        ];
    }
}
