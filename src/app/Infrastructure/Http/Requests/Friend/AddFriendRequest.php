<?php

namespace App\Infrastructure\Http\Requests\Friend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $userId
 * @property int $friendId
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
            'userId' => 'required|numeric',
            'friendId' => 'required|numeric'
        ];
    }
}
