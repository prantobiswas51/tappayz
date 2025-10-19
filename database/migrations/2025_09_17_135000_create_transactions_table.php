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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('vcc_id')->unique()->nullable();
            $table->string('transactionId')->unique()->nullable();
            $table->string('cardNum')->nullable();
            $table->string('clientId')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('merchantName')->nullable();
            $table->string('recordTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
