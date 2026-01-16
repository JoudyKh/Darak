<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class CreatePropertyRequest extends FormRequest
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
            'en_name' => 'required|string|max:255',
            'ar_name' => 'required|string|max:255',
            'en_description' => 'required',
            'ar_description' => 'required',
            'total_price' => 'required|numeric',
            'number' => 'required|numeric',
            'area' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_best' => 'required|boolean',
            'longitude' => 'string',
            'latitude' => 'string',
            'files'=>'required|array|min:1',
            'files.*'=>'file|mimes:'.implode(',',['jpeg','jpg','png','gif','bmp','tiff','svg','mp4','avi','mkv','mov','flv','webm','ogv'])
        ];
    }
}
