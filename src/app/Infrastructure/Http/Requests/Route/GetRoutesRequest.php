<?php

namespace App\Infrastructure\Http\Requests\Route;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property ?string cursor
 * @property ?string search
 * @property ?string sort
 * @property ?int sortType
 * @property ?string rating
 * @property ?string passing
 * @property ?int limit
 * @property ?string point
 */
class GetRoutesRequest extends FormRequest
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
            'search' => 'string',
            'sort' => 'string',
            'sortType' => 'numeric',
            'rating' => 'string',
            'limit' => 'numeric',
            'passing' => 'string',
            'point' => 'string'
        ];
    }
}

