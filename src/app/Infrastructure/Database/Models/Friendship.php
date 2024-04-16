<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property int $relationship_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $friend
 * @property-read FriendRelationshipType $relationship
 * @property-read User $user
 */
class Friendship extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'friend_id',
        'relationship_id'
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

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function friend(): BelongsTo {
        return $this->belongsTo(User::class, 'friend_id', 'id');
    }

    public function relationship(): BelongsTo {
        return $this->belongsTo(FriendRelationshipType::class, 'relationship_id', 'id');
    }
}
