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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_method'); //Paypal , payeer, crypto, bank, card
            $table->string('payment_id')->nullable()->unique();
            $table->string('payer_email')->nullable();
            $table->string('merchant')->nullable();
            $table->decimal('amount', 10, 2); // 525
            $table->enum('status', ['Pending', 'Approved', 'Insufficient Balance', 'Canceled'])->default('Pending'); //pending, failed, success
            $table->enum('type', ['Deposit', 'Withdrawal', 'Credit', 'Debit']);
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
