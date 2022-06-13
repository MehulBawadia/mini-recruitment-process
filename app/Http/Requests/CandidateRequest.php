<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:filter',
            'mobile' => 'required|numeric|digits_between:8,12',
            'cv_resume' => 'nullable|file|mimes:PDF,pdf|max:2048',
            'comments' => 'required|string|max:255',
            'interview_by' => 'required|string|max:255',
            'interview_feedback' => 'required|string|max:255',
            'interview_scheduled_at' => 'required',
            'agency_id' => 'required|integer|exists:agencies,id',
            'is_selected' => 'nullable',
        ];
    }
}
