<?php

namespace Untitledpng\LaravelInvite\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;
use Untitledpng\LaravelInvite\Contracts\Repositories\InviteRepositoryContract;
use Untitledpng\LaravelInvite\Models\Invite;

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
                $user->getAttribute('id')
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
