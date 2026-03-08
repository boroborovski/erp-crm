<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ActivityEvent;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

final class NoteablePivot extends MorphPivot
{
    protected $table = 'noteables';

    public $incrementing = true;

    protected static function booted(): void
    {
        static::created(function (self $pivot): void {
            /** @var class-string<\Illuminate\Database\Eloquent\Model> $subjectClass */
            $subjectClass = $pivot->noteable_type;

            if (! class_exists($subjectClass)) {
                return;
            }

            $subject = $subjectClass::find($pivot->noteable_id);

            if ($subject === null || ! method_exists($subject, 'recordActivity')) {
                return;
            }

            $note = Note::find($pivot->note_id);

            $subject->recordActivity(ActivityEvent::NoteAdded, $note?->title);
        });
    }
}
