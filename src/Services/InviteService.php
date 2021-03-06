<?php

namespace Untitledpng\LaravelInvite\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Auth0\Laravel\Contract\Model\Stateful\User;
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
            'created_by_local_user_id' => $user->localUser()->id,
            'code' => Str::uuid(),
            'valid_until' => $expires
                ? now()->addHours(config('invite.invite_hours_valid'))->toDateTimeString()
                : null,
        ]);

        return tap($invite)->save();
    }

    /**
     * @inheritDoc
     */
    public function getAllInvitesByUser(User $user): Collection
    {
        return Invite::query(
            //
        )->where(
            'created_by_local_user_id',
            $user->localUser()->id
        )->where(
            static function (Builder $query) {
                $query->where(
                    'valid_until',
                    '>=',
                    now()->addMinute()->toDateTimeString()
                )->orWhere(
                    'is_used',
                    true
                );
            }
        )->get();
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
    public function useInvite($newUser, Invite $invite): void
    {
        $invite->used_by_local_user_id = $newUser->id;
        $invite->is_used = true;
        $invite->save();
    }
}
