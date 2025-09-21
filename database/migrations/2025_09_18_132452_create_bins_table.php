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
        Schema::create('bins', function (Blueprint $table) {
            $table->string('id')->primary(); // use API id as primary key
            $table->string('bin');
            $table->string('cr');
            $table->string('organization');
            $table->string('actualOpenCardPrice');
            $table->string('actualRechargeFeeRate');
            $table->boolean('enable')->default(true);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bins');
    }
};
