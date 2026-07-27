<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transfer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transfer_id');
            $table->integer('product_id');
            $table->double('qty');
            $table->integer('purchase_unit_id');
            $table->double('net_unit_cost');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
            $table->integer('variant_id')->nullable(); // From 2019_12_05_123802_add_variant_id_to_product_transfer_table.php
            $table->integer('product_batch_id')->nullable(); // From 2021_05_23_124848_add_product_batch_id_to_product_transfer_table.php
            $table->text('imei_number')->nullable(); // From 2021_10_11_104504_add_imei_number_to_product_transfer_table.php

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
        Schema::dropIfExists('product_transfer');
    }
}
