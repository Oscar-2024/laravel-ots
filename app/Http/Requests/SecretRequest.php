<?php

namespace App\Http\Requests;

use App\Enums\SecretExpirationOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SecretRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required_if:secret,share|max:1000',
            'password' => 'nullable|min:4|max:32',
            'recipient' => 'nullable|email',
            'expires_at' => ['required', new Enum(SecretExpirationOptions::class)],
        ];
    }
}
