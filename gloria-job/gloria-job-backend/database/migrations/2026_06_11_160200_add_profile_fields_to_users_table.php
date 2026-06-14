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
        Schema::table('users', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('cv');
            $table->json('skills')->nullable()->after('summary');
            $table->json('education')->nullable()->after('skills');
            $table->json('experience')->nullable()->after('education');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['summary', 'skills', 'education', 'experience']);
        });
    }
};
