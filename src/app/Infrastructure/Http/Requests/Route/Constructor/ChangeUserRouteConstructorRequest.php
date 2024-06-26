<?php

namespace App\Infrastructure\Http\Requests\Route\Constructor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property float $lat
 * @property float $lon
 * @property array{placeId: int, index: int} $items
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
            'lat' => 'required|numeric|min:-90|max:90',
            'lon' => 'required|numeric|min:-180|max:180',
            'items' => 'array',
            'items.*' => 'array:placeId,index'
        ];
    }
}
