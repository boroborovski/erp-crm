<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Enums\ActivityEvent;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasActivities
{
    /**
     * @return MorphMany<Activity, $this>
     */
    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity(ActivityEvent $event, ?string $description = null): void
    {
        $causerKey = auth()->id();

        $this->activities()->create([
            'team_id' => $this->team_id,
            'causer_id' => $causerKey,
            'event' => $event,
            'description' => $description,
        ]);
    }
}
