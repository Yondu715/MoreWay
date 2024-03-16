<?php

namespace App\Http\Requests\Friend;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userId' => 'required|string',
            'friendId' => 'required|string'
        ];
    }
}
