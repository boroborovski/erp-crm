<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignUlid('product_category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->decimal('unit_price', 10, 4)->default(0);
            $table->char('currency', 3)->default('USD');
            $table->string('unit', 10)->default('ea');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('team_id', 'idx_products_team');
            $table->index('product_category_id', 'idx_products_category');
            $table->index('is_active', 'idx_products_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
