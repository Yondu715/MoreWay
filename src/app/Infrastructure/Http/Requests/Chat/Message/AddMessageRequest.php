<?php

namespace App\Infrastructure\Http\Requests\Chat\Message;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $userId
 * @property string $message
 */
class AddMessageRequest extends FormRequest
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
            'message' => 'required|string',
        ];
    }
}
