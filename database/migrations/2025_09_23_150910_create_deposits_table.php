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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('tx_id')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('receiver_id')->nullable();
            $table->string('amount');
            $table->enum('type', ['Manual', 'Auto']);
            $table->string('method')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->default('pending');
            $table->string('screenshot_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
