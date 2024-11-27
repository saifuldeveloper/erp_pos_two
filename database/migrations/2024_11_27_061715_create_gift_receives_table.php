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
        Schema::create('gift_receives', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_id')->nullable();
            $table->string('gift_transaction_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('quantity_received')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_receives');
    }
};
