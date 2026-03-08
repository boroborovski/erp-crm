<?php

declare(strict_types=1);

namespace App\Enums;

enum ActivityEvent: string
{
    case Created = 'created';
    case Updated = 'updated';
    case NoteAdded = 'note_added';
    case TaskAdded = 'task_added';
    case EmailSent = 'email_sent';

    public function label(): string
    {
        return match ($this) {
            self::Created => __('activities.events.created'),
            self::Updated => __('activities.events.updated'),
            self::NoteAdded => __('activities.events.note_added'),
            self::TaskAdded => __('activities.events.task_added'),
            self::EmailSent => __('activities.events.email_sent'),
        };
    }
}
