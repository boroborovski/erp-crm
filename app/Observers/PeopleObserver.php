<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\People;

final readonly class PeopleObserver
{
    public function creating(People $people): void
    {
        if (auth('web')->check()) {
            $people->creator_id = (string) auth('web')->id();
            $people->team_id = auth('web')->user()->currentTeam->getKey();
        }
    }

    public function created(People $people): void
    {
        $people->recordActivity(ActivityEvent::Created);
    }

    public function updated(People $people): void
    {
        $people->recordActivity(ActivityEvent::Updated);
    }

    public function saved(People $people): void
    {
        $people->invalidateAiSummary();
    }
}
