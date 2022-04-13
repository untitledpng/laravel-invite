<?php

namespace Untitledpng\LaravelInvite\Repositories;

use App\Models\User;
use Flashpoint\ShopByLook\Models\Invite;
use Illuminate\Database\Eloquent\Collection;
use Untitledpng\LaravelInvite\Contracts\Repositories\InviteRepositoryContract;

class InviteRepository implements InviteRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function getInviteByCode(string $code): ?Invite
    {
        return Invite::query()
            ->firstWhere('code', $code);
    }

    /**
     * @inheritDoc
     */
    public function getValidInvitesForUser(User $user): Collection
    {
        return Invite::query()
            ->where(
                'created_by_user_id',
                $user->id
            )->where(
                static function ($query) {
                    $query->whereNull('valid_until')
                        ->orWhere('valid_until', '>', now()->toDateTimeString());
                }
            )->get(
                //
            );
    }
}
