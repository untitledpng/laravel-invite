<?php

namespace Untitledpng\LaravelInvite\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Untitledpng\LaravelInvite\Models\Invite;
use Auth0\Laravel\Contract\Model\Stateful\User;

interface InviteRepositoryContract
{
    /**
     * @param  string $code
     * @return null|Invite
     */
    public function getInviteByCode(string $code): ?Invite;

    /**
     * @param  User $user
     * @return Collection<int, Invite>
     */
    public function getValidInvitesForUser(User $user): Collection;
}
