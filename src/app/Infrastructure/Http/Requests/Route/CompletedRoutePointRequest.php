<?php

namespace App\Infrastructure\Http\Requests\Route;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $userId
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
            'routePointId' => 'required|numeric',
        ];
    }
}
