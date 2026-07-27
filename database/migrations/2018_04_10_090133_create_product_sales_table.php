<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->index();
            $table->integer('product_id')->index();
            $table->double('qty');
            $table->integer('sale_unit_id');
            $table->double('net_unit_price');
            $table->double('discount');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
            $table->integer('variant_id')->nullable()->index(); // From 2019_11_29_182201_add_variant_id_to_product_sales_table.php
            $table->integer('product_batch_id')->nullable()->index(); // From 2021_03_11_132603_add_product_batch_id_to_product_sales_table.php
            $table->text('imei_number')->nullable(); // From 2021_10_03_170652_add_imei_number_to_product_sales_table.php
            $table->double('return_qty')->default(0); // From 2023_10_15_124306_add_return_qty_to_product_sales_table.php

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
        Schema::dropIfExists('product_sales');
    }
}
