<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignUlid('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('type', 20);
            $table->decimal('quantity', 10, 2);
            $table->text('note')->nullable();
            $table->foreignUlid('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('team_id', 'idx_stock_movements_team');
            $table->index('product_id', 'idx_stock_movements_product');
            $table->index('type', 'idx_stock_movements_type');
            $table->index('created_by', 'idx_stock_movements_created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
