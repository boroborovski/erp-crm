<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('entity', 30);
            $table->json('columns');
            $table->json('filters');
            $table->timestamps();

            $table->index('team_id', 'idx_reports_team');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
