<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function view(User $user, Product $product): bool
    {
        return $user->belongsToTeam($product->team);
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function update(User $user, Product $product): bool
    {
        return $user->belongsToTeam($product->team);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->belongsToTeam($product->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function restore(User $user, Product $product): bool
    {
        return $user->belongsToTeam($product->team);
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->belongsToTeam($product->team);
    }
}
