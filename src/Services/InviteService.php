<?php

namespace Untitledpng\LaravelInvite\Services;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User;
use Untitledpng\LaravelInvite\Contracts\Repositories\InviteRepositoryContract;
use Untitledpng\LaravelInvite\Contracts\Services\InviteServiceContract;
use Untitledpng\LaravelInvite\Models\Invite;

class InviteService implements InviteServiceContract
{
    /**
     * @param  InviteRepositoryContract $inviteRepository
     */
    public function __construct(public InviteRepositoryContract $inviteRepository)
    {
        //
    }

    /**
     * @param  User $user
     * @param  bool $expires
     * @return Invite
     */
    public function createInvite(User $user, bool $expires = true): Invite
    {
        $invite = new Invite([
            'created_by_user_id' => $user->getAttribute('id'),
            'code' => Str::uuid(),
            'valid_until' => $expires
                ? now()->hours(config('invite.invite_hours_valid'))->toDateTimeString()
                : null,
        ]);

        return tap($invite)->save();
    }

    /**
     * @inheritDoc
     */
    public function validateInvite(string $code): ?Invite
    {
        if (null === ($invite = $this->inviteRepository->getInviteByCode($code))) {
            return null;
        }

        if ($invite->is_used) {
            return null;
        }

        if (null !== $invite->valid_until && $invite->valid_until->lessThan(now())) {
            return null;
        }

        return $invite;
    }

    /**
     * @inheritDoc
     */
    public function useInvite(User $newUser, Invite $invite): void
    {
        $invite->used_by_user_id = $newUser->getAttribute('id');
        $invite->is_used = true;
        $invite->save();
    }
}
