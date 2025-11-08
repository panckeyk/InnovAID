<?php

namespace App\Http\Requests;


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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            // Validate the category is one of the allowed enum values
            'category' => ['required', 'string', Rule::in(['Technology', 'Social Impact', 'Research', 'Art & Design', 'Environment', 'Health'])],
            'goal_amount' => ['required', 'numeric', 'min:100'], // Example minimum goal
            'deadline' => ['required', 'date', 'after:today'], // Must be a future date
            'image' => ['required', 'image', 'max:2048'], // Required image, max 2MB
            'proposal_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // Optional PDF, max 5MB
        ];
    }
}
