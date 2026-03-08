<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->boolean('track_stock')->default(false)->after('is_active');
            $table->decimal('stock_quantity', 10, 2)->default(0)->after('track_stock');
            $table->decimal('low_stock_threshold', 10, 2)->nullable()->after('stock_quantity');

            $table->index('track_stock', 'idx_products_track_stock');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropIndex('idx_products_track_stock');
            $table->dropColumn(['track_stock', 'stock_quantity', 'low_stock_threshold']);
        });
    }
};
