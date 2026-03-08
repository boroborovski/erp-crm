<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EmailDirection;
use App\Models\Concerns\HasTeam;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $team_id
 * @property EmailDirection $direction
 * @property string|null $message_id
 * @property string|null $in_reply_to
 * @property string $from_email
 * @property string|null $from_name
 * @property list<string> $to
 * @property string $subject
 * @property string|null $body_html
 * @property string $body_text
 * @property Carbon $sent_at
 * @property Carbon|null $read_at
 * @property string|null $subject_type
 * @property string|null $subject_id
 */
final class Email extends Model
{
    use HasTeam;
    use HasUlids;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'team_id',
        'direction',
        'message_id',
        'in_reply_to',
        'from_email',
        'from_name',
        'to',
        'subject',
        'body_html',
        'body_text',
        'sent_at',
        'read_at',
        'subject_type',
        'subject_id',
    ];

    /**
     * @return array<string, string|class-string>
     */
    protected function casts(): array
    {
        return [
            'direction' => EmailDirection::class,
            'to' => 'array',
            'sent_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function subject(): MorphTo
    {
        return $this->morphTo('subject');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
