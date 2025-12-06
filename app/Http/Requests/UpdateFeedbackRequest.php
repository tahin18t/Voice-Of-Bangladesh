<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in-progress,resolved,closed',
            'location' => 'nullable|string|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|string',
        ];
    }
}
