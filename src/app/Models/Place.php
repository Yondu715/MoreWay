<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function ratings()
    {
        return $this->hasMany(PlaceRating::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PlaceImage::class);
    }
}
