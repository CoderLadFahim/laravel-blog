<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogpostRequest extends FormRequest
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
            'title' => ['bail', 'required', 'max:100', 'string'],
            'body' => ['bail', 'required', 'string'],
            'user_id' => ['bail', 'required'],
            'category_id' => ['bail', 'required'],
        ];
    }
}
