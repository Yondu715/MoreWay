<?php

namespace App\Http\Requests\Place;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property float $lat
 * @property float $lon
 * @property ?string cursor
 * @property ?string search
 * @property ?string sort
 * @property ?int sortType
 * @property ?string locality
 * @property ?string type
 * @property ?string rating
 * @property ?string distance
 * @property int limit
 */
class GetPlacesRequest extends FormRequest
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
            'cursor' => 'string',
            'search' => 'string',
            'sort' => 'string',
            'sortType' => 'numeric',
            'locality' => 'string',
            'type' => 'string',
            'rating' => 'string',
            'limit' => 'required|numeric'
        ];
    }
}
