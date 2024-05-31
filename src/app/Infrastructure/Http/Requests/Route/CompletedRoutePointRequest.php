<?php

namespace App\Infrastructure\Http\Requests\Route;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $userId
 * @property int $routePointId
 * @property float $lat
 * @property float $lon
 */
class CompletedRoutePointRequest extends FormRequest
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
            'routePointId' => 'required|numeric',
            'lat' => 'required|numeric|min:-90|max:90',
            'lon' => 'required|numeric|min:-180|max:180',
        ];
    }
}
