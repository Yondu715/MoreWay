<?php

namespace App\Http\Requests\Route;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $userId
 * @property string $text
 * @property int $rating
 */
class CreateRouteReviewRequest extends FormRequest
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
            'text' => 'string',
            'rating' => 'required|numeric'
        ];
    }
}
