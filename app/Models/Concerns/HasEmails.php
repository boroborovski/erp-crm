<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\Email;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasEmails
{
    /**
     * @return MorphMany<Email, $this>
     */
    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'subject')->latest('sent_at');
    }
}
