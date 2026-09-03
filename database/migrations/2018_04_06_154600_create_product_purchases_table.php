<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id')->index();
            $table->integer('product_id')->index();
            $table->double('qty');
            $table->double('recieved');
            $table->integer('purchase_unit_id');
            $table->double('net_unit_cost');
            $table->double('discount');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
            $table->integer('variant_id')->nullable()->index(); // From 2019_11_25_134922_add_variant_id_to_product_purchases_table.php
            $table->integer('product_batch_id')->nullable()->index(); // From 2021_03_07_093900_add_product_batch_id_to_product_purchases_table.php
            $table->text('imei_number')->nullable(); // From 2021_09_28_170126_add_imei_number_to_product_purchases_table.php
            $table->double('selling_price', 8, 2); // From 2024_10_09_180729_add_selling_price_to_product_purchases_table.php

            $table->timestamps();
            $table->index('created_at');
            $table->index(['product_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_purchases');
    }
}
