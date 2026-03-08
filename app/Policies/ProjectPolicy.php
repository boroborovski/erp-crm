<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class ProjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function view(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team);
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function update(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team);
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function restore(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team);
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team);
    }
}
