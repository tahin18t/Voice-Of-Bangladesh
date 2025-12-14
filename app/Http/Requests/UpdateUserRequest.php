<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => "sometimes|required|email|unique:users,email,{$userId}",
            'password' => 'nullable|string|min:6',
            'role_id' => 'nullable|exists:roles,id',
            'department' => 'nullable|string|max:255',
        ];
    }
}
