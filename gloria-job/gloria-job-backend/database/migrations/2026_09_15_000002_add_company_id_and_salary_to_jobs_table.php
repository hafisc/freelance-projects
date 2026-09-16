<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id')->constrained('companies')->onDelete('set null');
            $table->unsignedBigInteger('salary_min')->nullable()->after('experience');
            $table->unsignedBigInteger('salary_max')->nullable()->after('salary_min');
            $table->string('salary_category')->nullable()->after('salary_max');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id', 'salary_min', 'salary_max', 'salary_category']);
        });
    }
};
