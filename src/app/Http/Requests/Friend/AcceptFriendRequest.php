<?php

namespace App\Http\Requests\Friend;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $requestId
 */
class AcceptFriendRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'requestId' => 'required|numeric',
        ];
    }
}
