<?php

namespace App\Services\Place\Review;

use App\DTO\In\Place\CreateReviewDto;
use App\Exceptions\Review\FailedToCreateReview;
use App\Models\PlaceReview;
use Exception;

class ReviewService
{
    /**
     * @param CreateReviewDto $createReviewDto
     * @return PlaceReview
     * @throws FailedToCreateReview
     */
    public function create(CreateReviewDto $createReviewDto): PlaceReview
    {
        try {
            /** @var PlaceReview $placeReview */
            $placeReview = PlaceReview::query()->create([
                'author_id' => $createReviewDto->user_id,
                'place_id' => $createReviewDto->place_id,
                'text' => $createReviewDto->text,
                'rating' => $createReviewDto->rating
            ]);
        }
        catch (Exception){
            throw new FailedToCreateReview();
        }

        return $placeReview;
    }
}
