<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . ($this->user->id ?? ''),
        'role_id' => 'required|exists:roles,id',
        'outlet_id' => 'required|exists:outlet,id',
    ];

    if ($this->isMethod('post')) {
        $rules['password'] = 'required|min:8';
    } else {
        $rules['password'] = 'nullable|min:8';
    }

    return $rules;
}
}
