<?php

namespace App\Infrastructure\Database\Models;

use App\Infrastructure\Database\Models\Filters\AbstractFilter;
use App\Infrastructure\Database\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $creator_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $reviews_count
 * @property-read User $creator
 * @property-read Collection<int, RouteReview> $reviews
 * @property-read Collection<int, RoutePoint> $routePoints
 * @property-read int|null $route_points_count
 * @method filter(AbstractFilter $filters)
 */
class Route extends Model
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
        'creator_id'
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function routePoints(): HasMany
    {
        return $this->hasMany(RoutePoint::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(RouteReview::class);
    }

    public function rating(): ?float
    {
        return round($this->reviews()->avg('rating'), 2);
    }

    public function favoriteByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_favorite_routes');
    }

    public function activeByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_active_routes');
    }
}
