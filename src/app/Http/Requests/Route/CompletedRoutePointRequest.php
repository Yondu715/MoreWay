<?php

namespace App\Http\Requests\Route;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $userId
 * @property int $routeId
 * @property int $routePointId
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
            'routeId' => 'required|numeric',
            'routePointId' => 'required|numeric',
        ];
    }
}
