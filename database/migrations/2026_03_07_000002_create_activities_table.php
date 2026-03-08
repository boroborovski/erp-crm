<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table): void {
            $table->ulid('id')->primary();

            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignUlid('causer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->ulidMorphs('subject');

            $table->string('event', 50);
            $table->string('description')->nullable();

            $table->timestamps();

            $table->index(['subject_type', 'subject_id', 'created_at'], 'idx_activities_subject');
            $table->index('team_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
