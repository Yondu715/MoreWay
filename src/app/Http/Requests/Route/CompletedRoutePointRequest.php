<?php

namespace App\Http\Requests\Route;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
