<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class StockMovementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function view(User $user, StockMovement $stockMovement): bool
    {
        return $user->belongsToTeam($stockMovement->team);
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function update(User $user, StockMovement $stockMovement): bool
    {
        return $user->belongsToTeam($stockMovement->team);
    }

    public function delete(User $user, StockMovement $stockMovement): bool
    {
        return $user->belongsToTeam($stockMovement->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function restore(User $user, StockMovement $stockMovement): bool
    {
        return $user->belongsToTeam($stockMovement->team);
    }

    public function forceDelete(User $user, StockMovement $stockMovement): bool
    {
        return $user->belongsToTeam($stockMovement->team);
    }
}
