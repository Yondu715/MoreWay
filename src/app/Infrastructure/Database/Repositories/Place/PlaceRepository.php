<?php

namespace App\Infrastructure\Database\Repositories\Place;

use Closure;
use Throwable;
use Illuminate\Database\Eloquent\Model;
use App\Application\DTO\Out\Place\PlaceDto;
use App\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Place;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Utils\Mappers\Out\Place\PlaceDtoMapper;
use App\Application\Exceptions\Place\PlaceNotFound;
use App\Application\Contracts\Out\Repositories\Place\IPlaceRepository;
use App\Infrastructure\Database\Models\Filters\Place\PlaceFilterFactory;

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
     * @param int $placeId
     * @param Closure(float, float): float $distanceCalculator
     * @throws PlaceNotFound
     * @return PlaceDto
     */
    public function findById(int $placeId, Closure $distanceCalculator): PlaceDto
    {
        try {
            /** @var Place $place */
            $place = $this->model->query()->with(['images', 'type', 'locality'])->find($placeId);
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
            ->cursorPaginate(perPage: $getPlacesDto->limit, cursor: $getPlacesDto->cursor);
        return PlaceDtoMapper::fromPaginator($places, $distanceCalculator);
    }
}
