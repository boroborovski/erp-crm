<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\Opportunity;

final readonly class OpportunityObserver
{
    public function creating(Opportunity $opportunity): void
    {
        if (auth('web')->check()) {
            $opportunity->creator_id = (string) auth('web')->id();
            $opportunity->team_id = auth('web')->user()->currentTeam->getKey();
        }
    }

    public function created(Opportunity $opportunity): void
    {
        $opportunity->recordActivity(ActivityEvent::Created);
    }

    public function updated(Opportunity $opportunity): void
    {
        $opportunity->recordActivity(ActivityEvent::Updated);
    }

    public function saved(Opportunity $opportunity): void
    {
        $opportunity->invalidateAiSummary();
    }
}
