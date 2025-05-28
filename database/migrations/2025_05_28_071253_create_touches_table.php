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
        Schema::create('touches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promoted_id')->constrained('promoted')->onDelete('cascade');
            $table->tinyInteger('touch_number');
            $table->enum('method', ['call', 'whatsapp', 'sms', 'other'])->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('touched_at')->useCurrent();
            $table->timestamps();

            $table->unique(['promoted_id', 'touch_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('touches');
    }
};
