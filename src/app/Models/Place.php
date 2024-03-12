<?php

namespace App\Models;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, PlaceComment> $comments
 * @property-read int|null $comments_count
 * @property-read Collection<int, PlaceImage> $images
 * @property-read int|null $images_count
 * @property-read Locality $locality
 * @property-read Collection<int, PlaceRating> $ratings
 * @property-read int|null $ratings_count
 * @property-read PlaceType $type
 */
class Place extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function comments(): HasMany
    {
        return $this->hasMany(PlaceComment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(PlaceRating::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PlaceImage::class);
    }
}