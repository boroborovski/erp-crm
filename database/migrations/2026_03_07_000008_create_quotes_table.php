<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignUlid('opportunity_id')->nullable()->constrained('opportunities')->nullOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('contact_id')->nullable()->constrained('people')->nullOnDelete();
            $table->string('quote_number');
            $table->string('status', 20)->default('draft');
            $table->date('valid_until')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('team_id', 'idx_quotes_team');
            $table->index('opportunity_id', 'idx_quotes_opportunity');
            $table->index('company_id', 'idx_quotes_company');
            $table->index('contact_id', 'idx_quotes_contact');
            $table->index('status', 'idx_quotes_status');
            $table->unique(['team_id', 'quote_number'], 'uniq_quotes_team_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
