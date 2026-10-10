<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreCollegeReviewRequest extends FormRequest
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
            'course' => ['nullable', 'string', 'max:120'],
            'course_enrolled' => ['nullable', 'string', 'max:120'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'review' => ['required_without:review_text', 'nullable', 'string', 'min:15', 'max:1500'],
            'review_text' => ['required_without:review', 'nullable', 'string', 'min:15', 'max:1500'],
            'website_hp' => ['nullable', 'max:0'],
        ];
    }

    /**
     * Configure the validator instance with honeypot security check.
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
            'reviewer_name.required' => 'Please provide your full name.',
            'reviewer_name.min' => 'Your name must be at least 2 characters.',
            'email.required' => 'Please provide a valid email address.',
            'email.email' => 'Please provide a valid email format.',
            'rating.required' => 'Please select a rating between 1 and 5 stars.',
            'rating.between' => 'Rating must be between 1 and 5 stars.',
            'review.required_without' => 'Please write your detailed feedback (minimum 15 characters).',
            'review.min' => 'Your review must be at least 15 characters long.',
            'review.max' => 'Your review cannot exceed 1500 characters.',
            'review_text.min' => 'Your review must be at least 15 characters long.',
            'review_text.max' => 'Your review cannot exceed 1500 characters.',
            'website_hp.max' => 'Spam submission detected.',
        ];
    }

    /**
     * Resolve final course name (either course or course_enrolled).
     */
    public function courseName(): ?string
    {
        return $this->validated('course') ?? $this->validated('course_enrolled');
    }

    /**
     * Resolve final review text (either review or review_text).
     */
    public function reviewBody(): string
    {
        return (string) ($this->validated('review') ?? $this->validated('review_text'));
    }
}
