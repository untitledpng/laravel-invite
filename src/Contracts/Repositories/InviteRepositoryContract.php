<?php

namespace Untitledpng\LaravelInvite\Contracts\Repositories;

use Flashpoint\ShopByLook\Models\Invite;
use Illuminate\Database\Eloquent\Collection;

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
