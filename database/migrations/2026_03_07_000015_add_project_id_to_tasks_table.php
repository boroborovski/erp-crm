<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table): void {
            $table->foreignUlid('project_id')->nullable()->constrained('projects')->nullOnDelete()->after('creator_id');
            $table->index('project_id', 'idx_tasks_project');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table): void {
            $table->dropForeign(['project_id']);
            $table->dropIndex('idx_tasks_project');
            $table->dropColumn('project_id');
        });
    }
};
