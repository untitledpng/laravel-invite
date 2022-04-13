<?php

namespace Flashpoint\ShopByLook\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Invite
 *
 * @property int $id
 * @property null|int $created_by_user_id
 * @property null|int $used_by_user_id
 * @property string $code
 * @property bool $is_used
 * @property null|Carbon $valid_until
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relations
 * @property User $usedBy
 *
 * Attributes
 * @property bool $isUsed
 */
class Invite extends Model
{
    /**
     * @inheritDoc
     */
    protected $table = 'user_invites';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'created_by_user_id',
        'used_by_user_id',
        'code',
        'valid_until',
    ];

    /**
     * @inheritDoc
     */
    protected $dates = [
        'valid_until',
        'created_at',
        'updated_at',
    ];

    /**
     * @inheritDoc
     */
    protected $appends = [
        'isUsed',
    ];

    /**
     * Get the user that has used the invite.
     *
     * @return BelongsTo
     */
    public function usedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }

    /**
     * This indicates if the invite has been used.
     *
     * @return bool
     */
    public function getIsUsedAttribute(): bool
    {
        return null === $this->used_by_user_id;
    }
}