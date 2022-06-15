<?php

namespace Untitledpng\LaravelInvite\Contracts\Services;

use Illuminate\Support\Collection;
use Untitledpng\LaravelInvite\Models\Invite;
use Auth0\Laravel\Contract\Model\Stateful\User;

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
     * Get all used and active invites for the
     * given user.
     *
     * @param  User $user
     * @return Collection<Int, User>
     */
    public function getAllInvitesByUser(User $user): Collection;

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
