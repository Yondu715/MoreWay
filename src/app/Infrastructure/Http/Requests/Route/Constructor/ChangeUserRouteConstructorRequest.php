<?php

namespace App\Infrastructure\Http\Requests\Route\Constructor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array{placeId: int, index: int} $routePoints
 */
class ChangeUserRouteConstructorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'routePoints' => 'array',
            'routePoints.*' => 'array:placeId,index'
        ];
    }
}
