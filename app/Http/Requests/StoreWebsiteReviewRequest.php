<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreWebsiteReviewRequest extends FormRequest
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
            'reviewer_name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'title' => ['nullable', 'string', 'max:150'],
            'review' => ['required', 'string', 'min:15', 'max:1500'],
            'website_hp' => ['nullable', 'max:0'],
        ];
    }

    /**
     * Configure the validator instance with honeypot spam protection.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! empty($this->input('website_hp'))) {
                $validator->errors()->add('website_hp', 'Spam submission detected.');
            }
        });
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'reviewer_name.required' => 'Please provide your name.',
            'reviewer_name.min' => 'Your name must be at least 2 characters long.',
            'email.required' => 'Please provide a valid email address.',
            'email.email' => 'Please provide a valid email format.',
            'rating.required' => 'Please select a star rating between 1 and 5.',
            'rating.between' => 'Rating must be between 1 and 5 stars.',
            'review.required' => 'Please share your feedback (minimum 15 characters).',
            'review.min' => 'Your review must be at least 15 characters long.',
            'review.max' => 'Your review cannot exceed 1500 characters.',
            'website_hp.max' => 'Spam submission detected.',
        ];
    }
}
