<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('return_id')->index();
            $table->integer('product_id')->index();
            $table->double('qty');
            $table->integer('sale_unit_id');
            $table->double('net_unit_price');
            $table->double('discount');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
            $table->integer('variant_id')->nullable()->index(); // From 2019_12_08_114954_add_variant_id_to_product_returns_table.php
            $table->integer('product_batch_id')->nullable()->index(); // From 2021_05_19_120127_add_product_batch_id_to_product_returns_table.php
            $table->text('imei_number')->nullable(); // From 2021_10_10_145214_add_imei_number_to_product_returns_table.php

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
        Schema::dropIfExists('product_returns');
    }
}
