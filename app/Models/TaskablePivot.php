<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ActivityEvent;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

final class TaskablePivot extends MorphPivot
{
    protected $table = 'taskables';

    public $incrementing = true;

    protected static function booted(): void
    {
        static::created(function (self $pivot): void {
            /** @var class-string<\Illuminate\Database\Eloquent\Model> $subjectClass */
            $subjectClass = $pivot->taskable_type;

            if (! class_exists($subjectClass)) {
                return;
            }

            $subject = $subjectClass::find($pivot->taskable_id);

            if ($subject === null || ! method_exists($subject, 'recordActivity')) {
                return;
            }

            $task = Task::find($pivot->task_id);

            $subject->recordActivity(ActivityEvent::TaskAdded, $task?->title);
        });
    }
}
