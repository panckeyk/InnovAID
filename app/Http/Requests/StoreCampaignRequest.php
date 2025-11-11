<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rule;

class StoreCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'student';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            // Validate the category is one of the allowed enum values
            'category' => ['required', 'string', Rule::in(['Technology', 'Social Impact', 'Research', 'Art & Design', 'Environment', 'Health'])],
            'goal_amount' => ['required', 'numeric', 'min:100', 'max:999999999.99'], // Minimum $100, reasonable maximum
            'deadline' => ['required', 'date', 'after:today'], // Must be a future date
            'image' => [
                request()->isMethod('POST') ? 'required' : 'nullable', 
                'image', 
                'mimes:jpeg,jpg,png,gif,webp',
                'max:5120' // 5MB in kilobytes
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.min' => 'The title must be at least 3 characters.',
            'description.min' => 'The description must be at least 10 characters.',
            'description.max' => 'The description may not be greater than 5000 characters.',
            'goal_amount.min' => 'The funding goal must be at least $100.',
            'goal_amount.max' => 'The funding goal is too large.',
            'deadline.after' => 'The deadline must be a future date.',
            'image.required' => 'Please upload a campaign image.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, jpg, png, gif, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ];
    }
}