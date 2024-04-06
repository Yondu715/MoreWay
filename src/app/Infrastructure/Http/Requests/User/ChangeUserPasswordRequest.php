<?php

namespace App\Infrastructure\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $oldPassword
 * @property string $newPassword
 */
class ChangeUserPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oldPassword' => 'required|string|max:255',
            'newPassword' => 'required|string|max:255'
        ];
    }
}
