<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Milestone;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class MilestonePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function view(User $user, Milestone $milestone): bool
    {
        return $user->belongsToTeam($milestone->project->team);
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function update(User $user, Milestone $milestone): bool
    {
        return $user->belongsToTeam($milestone->project->team);
    }

    public function delete(User $user, Milestone $milestone): bool
    {
        return $user->belongsToTeam($milestone->project->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }
}
