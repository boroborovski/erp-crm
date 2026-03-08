<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->ulid('id')->primary();

            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('opportunity_id')->nullable()->constrained('opportunities')->nullOnDelete();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status', 20)->default('planning');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('order_column', 20, 10)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['team_id', 'deleted_at'], 'idx_projects_team');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
