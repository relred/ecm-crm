<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobilization_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role'); // Store the role at the time of activity
            $table->string('state')->nullable(); // Store the state at the time of activity
            $table->string('municipality')->nullable(); // Store the municipality at the time of activity
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate entries for same user
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobilization_activities');
    }
}; 