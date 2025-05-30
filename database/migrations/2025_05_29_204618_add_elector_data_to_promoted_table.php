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
        Schema::table('promoted', function (Blueprint $table) {
            $table->string('elector_key')->nullable();
            $table->string('curp')->nullable();
            $table->string('electoral_section')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promoted', function (Blueprint $table) {
            $table->dropColumn(['elector_key', 'curp', 'electoral_section']);
        });
    }
};
