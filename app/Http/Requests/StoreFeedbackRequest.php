<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'priority' => 'nullable|in:low,medium,high,critical',
            'location' => 'nullable|string|max:255',
            'tracking_id' => 'sometimes|string|max:50',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:2048',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|max:2048',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
