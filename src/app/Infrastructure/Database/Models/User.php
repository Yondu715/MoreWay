<?php

namespace App\Infrastructure\Database\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use TCG\Voyager\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int $id
 * @property int|null $role_id
 * @property string $name
 * @property string $email
 * @property string|null $avatar
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, UserAchievementProgress> $achievements
 * @property-read int|null $achievements_count
 * @property-read UserActiveRoute|null $activeRoute
 * @property-read Collection<int, Chat> $chats
 * @property-read int|null $chats_count
 * @property-read Collection<int, Route> $favoriteRoutes
 * @property-read int|null $favorite_routes_count
 * @property-read Collection<int, User> $friends
 * @property-read int|null $friends_count
 * @property mixed $locale
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Role|null $role
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read UserScore|null $score
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 */
class User extends \TCG\Voyager\Models\User implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array<int, null>
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function score(): HasOne
    {
        return $this->hasOne(UserScore::class);
    }

    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_members');
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(UserAchievementProgress::class);
    }

    public function activeRoute(): HasOne
    {
        return $this->hasOne(UserActiveRoute::class);
    }

    public function favoriteRoutes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class, 'user_favorite_routes');
    }
}
