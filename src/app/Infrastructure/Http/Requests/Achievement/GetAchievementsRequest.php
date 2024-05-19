<?php

namespace App\Infrastructure\Http\Requests\Achievement;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property ?string $cursor
 * @property ?int $limit
 */
class GetAchievementsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cursor' => 'string',
            'limit' => 'numeric'
        ];
    }
}
