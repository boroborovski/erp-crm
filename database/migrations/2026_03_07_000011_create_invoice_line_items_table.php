<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_line_items', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignUlid('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('description');
            $table->decimal('quantity', 10, 4)->default(1);
            $table->decimal('unit_price', 10, 4)->default(0);
            $table->decimal('discount_pct', 5, 2)->default(0);
            $table->decimal('tax_pct', 5, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('invoice_id', 'idx_invoice_line_items_invoice');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_line_items');
    }
};
