<?php

namespace App\Http\Requests\PlaceReview;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int userId
 * @property int rating
 * @property ?string text
 */
class CreatePlaceReviewRequest extends FormRequest
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
            'rating' => 'required|numeric',
            'text' => 'string'
        ];
    }
}
