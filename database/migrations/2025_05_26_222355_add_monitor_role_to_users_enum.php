<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'coordinator', 'operator', 'subcoordinator', 'promoter', 'monitor') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_enum', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'coordinator', 'operator', 'subcoordinator', 'promoter') NOT NULL");
        });
    }
};
