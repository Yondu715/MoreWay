<?php

namespace App\Http\Requests\Friend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $userId
 * @property string $friendId
 */
class AddFriendRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userId' => 'required|string',
            'friendId' => 'required|string'
        ];
    }
}
