<?php

namespace App\Lib\Rating;

use App\Models\Place;

class RatingManager
{
    /**
     * @param Place $place
     * @return float|null
     */
    public static function calc(Place $place): ?float
    {
        $reviews = $place->reviews();

        if($reviews->exists()) {
            $sum = 0;
            foreach ($reviews->get()->all() as $comment) {
                $sum += $comment->rating;
            }
            return $sum / $reviews->count();
        }

        return null;
    }
}
