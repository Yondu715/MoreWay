<?php

namespace App\Infrastructure\Database\Repositories\Place;

use App\Application\Contracts\Out\Repositories\Place\IPlaceRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceDto;
use App\Application\Exceptions\Place\PlaceNotFound;
use App\Infrastructure\Database\Models\Filters\Place\PlaceFilterFactory;
use App\Infrastructure\Database\Models\Place;
use App\Utils\Mappers\Out\Place\PlaceDtoMapper;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class PlaceRepository implements IPlaceRepository
{
    private readonly Model $model;

    public function __construct(
        private readonly PlaceFilterFactory $placeFilterFactory,
        Place $place
    ) {
        $this->model = $place;
    }

    /**
     * @param GetPlaceDto $getPlaceDto
     * @param Closure(float, float): float $distanceCalculator
     * @throws PlaceNotFound
     * @return PlaceDto
     */
    public function getById(GetPlaceDto $getPlaceDto, Closure $distanceCalculator): PlaceDto
    {
        try {
            /** @var Place $place */
            $place = $this->model->query()->find($getPlaceDto->id);
            return PlaceDtoMapper::fromPlaceModel(
                $place,
                $distanceCalculator($place->lat, $place->lon)
            );
        } catch (Throwable) {
            throw new PlaceNotFound();
        }
    }

    /**
     * @param GetPlacesDto $getPlacesDto
     * @param Closure(float, float): float $distanceCalculator
     * @return CursorDto
     */
    public function getAll(GetPlacesDto $getPlacesDto, Closure $distanceCalculator): CursorDto
    {
        $places = $this->model
            ->filter($this->placeFilterFactory->create($getPlacesDto->filter, $distanceCalculator))
            ->cursorPaginate(perPage: $getPlacesDto->limit ?? 2, cursor: $getPlacesDto->cursor);
        return PlaceDtoMapper::fromPaginator($places, function ($place) use ($distanceCalculator) {
            return PlaceDtoMapper::fromPlaceModel($place, $distanceCalculator($place->lat, $place->lon));
        });
    }
}
