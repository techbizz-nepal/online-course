<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required | min: 1 | max: 149',
            'price' => 'required | numeric | min: 0',
            'booking_dates' => 'required | min: 1',
            'image' => 'required | image | max: 2048',
            'description' => 'max: 1500',
            'course_code' => 'required | min: 1 | max: 19',
            'campus' => 'required | min: 1 | max: 150',
            'study_area' => 'required | min: 1 | max: 150',
            'course_length' => 'required | min: 1 | max: 24',
            'fee_details' => 'required | min: 1 | max: 1500',
            'prerequisites' => 'max: 1500',
            'course_duration' => 'max: 1500',
            'additional_details' => 'max: 1500',
            'detail_image' => 'required | image | max: 2048',
            'category_id' => 'required | exists:categories,id'
        ];
    }
}
