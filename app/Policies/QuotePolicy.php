<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class QuotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function view(User $user, Quote $quote): bool
    {
        return $user->belongsToTeam($quote->team);
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function update(User $user, Quote $quote): bool
    {
        return $user->belongsToTeam($quote->team);
    }

    public function delete(User $user, Quote $quote): bool
    {
        return $user->belongsToTeam($quote->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function restore(User $user, Quote $quote): bool
    {
        return $user->belongsToTeam($quote->team);
    }

    public function forceDelete(User $user, Quote $quote): bool
    {
        return $user->belongsToTeam($quote->team);
    }
}
