<?php

namespace App\Services\Review;

use App\DTO\In\Place\CreateReviewDto;
use App\Models\PlaceReview;

class ReviewService
{
    /**
     * @param CreateReviewDto $createReviewDto
     * @return PlaceReview
     */
    public function create(CreateReviewDto $createReviewDto): PlaceReview
    {

        /** @var PlaceReview $placeReview */
        $placeReview = PlaceReview::query()->create([
            'author_id' => $createReviewDto->author_id,
            'place_id' => $createReviewDto->place_id,
            'text' => $createReviewDto->text,
            'rating' => $createReviewDto->rating
        ]);

        return $placeReview;
    }
}
