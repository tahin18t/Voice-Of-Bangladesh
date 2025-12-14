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
            'priority' => 'nullable|in:low,medium,high,critical',
            'status' => 'nullable|in:pending,assigned,in_progress,resolved,closed',
            'location' => 'nullable|string|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:2048',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|max:2048',
        ];
    }
}
