<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('milestones', function (Blueprint $table): void {
            $table->ulid('id')->primary();

            $table->foreignUlid('project_id')->constrained('projects')->cascadeOnDelete();

            $table->string('name');
            $table->date('due_date')->nullable();
            $table->boolean('is_completed')->default(false);

            $table->timestamps();

            $table->index(['project_id', 'is_completed'], 'idx_milestones_project');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
