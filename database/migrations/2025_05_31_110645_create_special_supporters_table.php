<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('special_supporters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('state')->nullable();
            $table->string('municipality')->nullable();
            $table->integer('mobilized_goal')->nullable();
            $table->integer('current_mobilized')->default(0);
            $table->string('registration_token')->unique();
            $table->boolean('is_registered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_supporters');
    }
};
