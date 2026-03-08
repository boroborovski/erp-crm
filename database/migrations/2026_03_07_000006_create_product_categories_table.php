<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();
            $table->ulid('parent_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->index('team_id', 'idx_product_categories_team');
            $table->index('parent_id', 'idx_product_categories_parent');
        });

        // Self-referencing FK must be added after the table (and its PK) are fully created.
        Schema::table('product_categories', function (Blueprint $table): void {
            $table->foreign('parent_id', 'fk_product_categories_parent')
                ->references('id')
                ->on('product_categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table): void {
            $table->dropForeign('fk_product_categories_parent');
        });

        Schema::dropIfExists('product_categories');
    }
};
