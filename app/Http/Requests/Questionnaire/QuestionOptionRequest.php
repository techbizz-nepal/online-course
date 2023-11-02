<?php

namespace App\Http\Requests\Questionnaire;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class QuestionOptionRequest extends FormRequest
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
            'option1' => ['required', 'string'],
            'option2' => ['required', 'string'],
            'option3' => ['required', 'string'],
            'option4' => ['required', 'string'],
            'is_correct' => ['required', 'string'],
        ];
    }
}
