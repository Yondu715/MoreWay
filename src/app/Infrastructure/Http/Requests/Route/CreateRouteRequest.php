<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Route;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property int $userId
 * @property array $routePoints
 */
class CreateRouteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'userId' => 'required|numeric',
            'routePoints' => 'required|array',
            'routePoints.*' => 'required|array:placeId,index'
        ];
    }
}
