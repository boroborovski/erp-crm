<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignUlid('quote_id')->nullable()->constrained('quotes')->nullOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('contact_id')->nullable()->constrained('people')->nullOnDelete();
            $table->string('invoice_number');
            $table->string('status', 20)->default('draft');
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('team_id', 'idx_invoices_team');
            $table->index('quote_id', 'idx_invoices_quote');
            $table->index('company_id', 'idx_invoices_company');
            $table->index('contact_id', 'idx_invoices_contact');
            $table->index('status', 'idx_invoices_status');
            $table->index('due_date', 'idx_invoices_due_date');
            $table->unique(['team_id', 'invoice_number'], 'uniq_invoices_team_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
