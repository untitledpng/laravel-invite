<?php

namespace Untitledpng\LaravelInvite\Contracts\Services;

use Untitledpng\LaravelInvite\Models\Invite;
use Illuminate\Foundation\Auth\User;

interface InviteServiceContract
{
    /**
     * Create a new invite linked to the given user
     * that can not expire if needed.
     *
     * @param  User $user
     * @param  bool $expires
     * @return Invite
     */
    public function createInvite(User $user, bool $expires = true): Invite;

    /**
     * Validate the given invite for use.
     *
     * @param  string $code
     * @return null|Invite
     */
    public function validateInvite(string $code): ?Invite;

    /**
     * Use the given invite with the new registered user.
     *
     * @param  User $newUser
     * @param  Invite $invite
     * @return void
     */
    public function useInvite(User $newUser, Invite $invite): void;
}
