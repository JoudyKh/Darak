<?php

namespace App\Http\Requests\PSection;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePSectionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'en_name' => 'string|max:255',
            'ar_name' => 'string|max:255',
            'image' => 'file',
        ];
    }
}
