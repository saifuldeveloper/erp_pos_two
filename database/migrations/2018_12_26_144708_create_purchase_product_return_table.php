<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseProductReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_product_return', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('return_id')->index();
            $table->integer('product_id')->index();
            $table->double('qty');
            $table->integer('purchase_unit_id');
            $table->double('net_unit_cost');
            $table->double('discount');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
            $table->integer('variant_id')->nullable()->index(); // From 2019_12_08_203146_add_variant_id_to_purchase_product_return_table.php
            $table->integer('product_batch_id')->nullable()->index(); // From 2021_05_22_105611_add_product_batch_id_to_purchase_product_return_table.php
            $table->text('imei_number')->nullable(); // From 2021_10_12_160107_add_imei_number_to_purchase_product_return_table.php

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_product_return');
    }
}
