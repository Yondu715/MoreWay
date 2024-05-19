<?php

namespace App\Infrastructure\Http\Requests\Rating;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property ?string $cursor
 * @property ?int $limit
 */
class GetRatingRequest extends FormRequest
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
