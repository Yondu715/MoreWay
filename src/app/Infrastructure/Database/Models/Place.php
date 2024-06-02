<?php

namespace App\Infrastructure\Database\Models;

use App\Infrastructure\Database\Models\Filters\AbstractFilter;
use App\Infrastructure\Database\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $lat
 * @property float $lon
 * @property int $locality_id
 * @property int $type_id
 * @property float $distance
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $reviews_count
 * @property-read Collection<int, PlaceReview> $reviews
 * @property-read Collection<int, PlaceImage> $images
 * @property-read int|null $images_count
 * @property-read Locality $locality
 * @property-read PlaceType $type
 * @method filter(AbstractFilter $filters)
 */
class Place extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'lat',
        'lon',
        'locality_id',
        'type_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(PlaceType::class, 'type_id', 'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(PlaceReview::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PlaceImage::class);
    }

    public function rating(): ?float
    {
        return round($this->reviews()->avg('rating'), 2);
    }

    public function routeConstructorsPoints(): HasMany
    {
        return $this->hasMany(RouteConstructorPoint::class, 'place_id', 'id');
    }
}
