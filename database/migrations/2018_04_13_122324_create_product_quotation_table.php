<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_quotation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quotation_id');
            $table->integer('product_id');
            $table->double('qty');
            $table->integer('sale_unit_id');
            $table->double('net_unit_price');
            $table->double('discount');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
            $table->integer('variant_id')->nullable(); // From 2019_12_04_121311_add_variant_id_to_product_quotation_table.php
            $table->integer('product_batch_id')->nullable(); // From 2021_05_26_153106_add_product_batch_id_to_product_quotation_table.php

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
        Schema::dropIfExists('product_quotation');
    }
}
