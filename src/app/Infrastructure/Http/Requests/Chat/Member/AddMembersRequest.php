<?php

namespace App\Infrastructure\Http\Requests\Chat\Member;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array<int, int> $members
 */
class AddMembersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'members' => 'required|array',
            'members.*' => 'integer'
        ];
    }
}
