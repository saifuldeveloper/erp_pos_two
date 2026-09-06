<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            $table->integer('product_batch_id')->nullable()->index();
            $table->integer('warehouse_id')->unsigned()->index();
            $table->integer('variant_id')->nullable()->unsigned()->index();
            $table->text('imei_number')->nullable();
            $table->double('qty', 15, 2)->default(0);
            $table->double('price', 15, 2)->nullable();
            $table->timestamps();
            $table->index('created_at');

            // Laravel 11 standard virtual stored generated column
            $table->string('unique_key')->storedAs("CONCAT(product_id, '-', warehouse_id, '-', COALESCE(variant_id, 0), '-', COALESCE(product_batch_id, 0))");

            $table->unique('unique_key', 'unique_stock_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_warehouse');
    }
};
