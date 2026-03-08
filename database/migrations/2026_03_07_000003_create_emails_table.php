<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table): void {
            $table->ulid('id')->primary();

            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();

            $table->string('direction', 20);

            $table->string('message_id')->nullable()->unique();
            $table->string('in_reply_to')->nullable();

            $table->string('from_email');
            $table->string('from_name')->nullable();
            $table->json('to');

            $table->string('subject');
            $table->longText('body_html')->nullable();
            $table->longText('body_text');

            $table->timestamp('sent_at');
            $table->timestamp('read_at')->nullable();

            $table->string('subject_type')->nullable();
            $table->ulid('subject_id')->nullable();

            $table->timestamps();

            $table->index(['subject_type', 'subject_id'], 'idx_emails_subject');
            $table->index(['team_id', 'sent_at'], 'idx_emails_team_sent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
