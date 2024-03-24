<?php

namespace App\Http\Requests\Route;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property int $creatorId
 * @property array $routePoints
 */
class CreateRouteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'creatorId' => 'required|numeric',
            'routePoints' => 'required|array:index,placeId'
        ];
    }
}
