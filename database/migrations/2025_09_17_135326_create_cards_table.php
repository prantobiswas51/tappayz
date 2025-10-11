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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('number')->unique()->nullable();
            $table->string('expiryDate')->nullable();
            $table->string('cvv')->nullable();
            $table->string('vcc_id')->nullable();
            $table->string('organization')->nullable();
            $table->string('email')->nullable();
            $table->decimal('cardBalance', 12, 2)->default(0);

            $table->string('bin')->nullable();
            $table->string('binId')->nullable();

            $table->string('state')->nullable();
            $table->string('remark')->nullable();
            $table->string('createTime')->nullable();
            $table->string('modifyTime')->nullable();
            $table->string('adapterSign')->nullable();
            $table->string('totalConsume')->nullable();
            $table->string('totalRefund')->nullable();
            $table->string('totalRecharge')->nullable();

            $table->string('totalCashOut')->nullable();
            $table->string('bankCardId')->nullable();

            $table->string('hiddenNum')->nullable();
            $table->string('hiddenCvv')->nullable();
            $table->string('hiddenDate')->nullable();
            $table->string('isHidden')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
