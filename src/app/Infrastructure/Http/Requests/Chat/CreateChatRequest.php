<?php

namespace App\Infrastructure\Http\Requests\Chat;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property int $userId
 * @property int $routeId
 * @property array{id: int} $members
 */
class CreateChatRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'userId' => 'required|numeric',
            'routeId' => 'required|numeric',
            'members' => 'required|array',
            'members.*' => 'required|array:id'
        ];
    }
}
