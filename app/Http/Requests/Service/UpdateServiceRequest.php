<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'ar_name'=> 'string|max:255',
            'price' => 'numeric',
            'files'=>'array|min:1',
            'files.*'=>'file|mimes:'.implode(',',['jpeg','jpg','png','gif','bmp','tiff','svg','mp4','avi','mkv','mov','flv','webm','ogv']),
            'trashed_files' => 'array',
        ];
    }
}
