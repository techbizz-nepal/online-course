<?php

namespace App\Http\Requests\Questionnaire;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class QuestionImageableRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image_path' => 'file|mimetypes:image/*',
            'name' => 'required|regex:/[A-Za-z0-9_-]+/',
        ];
    }
}
