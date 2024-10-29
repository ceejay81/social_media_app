<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120'],
            'bio' => ['nullable', 'string', 'max:500'],
        ];
    }
}
