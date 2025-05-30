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
        Schema::table('promoted_imports', function (Blueprint $table) {
            $table->timestamp('cancelled_at')->nullable()->after('promoter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promoted_imports', function (Blueprint $table) {
            $table->dropColumn('cancelled_at');
        });
    }
};
