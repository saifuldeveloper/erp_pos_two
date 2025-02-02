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
        Schema::create('supplier_dues', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->integer('account_id')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->json('payment_ids')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_dues');
    }
};
