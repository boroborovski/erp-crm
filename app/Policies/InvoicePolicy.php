<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $user->belongsToTeam($invoice->team);
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->belongsToTeam($invoice->team);
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->belongsToTeam($invoice->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function restore(User $user, Invoice $invoice): bool
    {
        return $user->belongsToTeam($invoice->team);
    }

    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return $user->belongsToTeam($invoice->team);
    }
}
