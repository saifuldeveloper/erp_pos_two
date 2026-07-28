<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->index();
            $table->string('type')->nullable();
            $table->string('barcode_symbology')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('category_id');
            $table->integer('unit_id');
            $table->integer('purchase_unit_id');
            $table->integer('sale_unit_id');
            $table->double('cost')->nullable();
            $table->double('price');
            $table->double('qty')->nullable();
            $table->double('alert_quantity')->nullable();
            $table->tinyInteger('promotion')->nullable();
            $table->string('promotion_price')->nullable();
            $table->date('starting_date')->nullable();
            $table->date('last_date')->nullable();
            $table->integer('tax_id')->nullable();
            $table->integer('tax_method')->nullable();
            $table->longText('image')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->text('product_details')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('file')->nullable(); // From 2018_07_22_130541_add_digital_to_products_table.php
            $table->string('product_list')->nullable(); // From 2018_11_19_094650_add_combo_to_products_table.php
            $table->string('qty_list')->nullable(); // From 2018_11_19_094650_add_combo_to_products_table.php
            $table->string('price_list')->nullable(); // From 2018_11_19_094650_add_combo_to_products_table.php
            $table->boolean('is_variant')->nullable(); // From 2019_11_13_145619_add_is_variant_to_products_table.php
            $table->boolean('is_diffPrice')->nullable(); // From 2020_11_02_050633_add_is_diff_price_to_products_table.php
            $table->boolean('is_batch')->nullable(); // From 2021_03_25_125421_add_is_batch_to_products_table.php
            $table->string('variant_list')->nullable(); // From 2021_07_06_132716_add_variant_list_to_products_table.php
            $table->boolean('is_imei')->nullable(); // From 2021_09_27_161141_add_is_imei_to_products_table.php
            $table->double('daily_sale_objective')->nullable(); // From 2022_05_26_195506_add_daily_sale_objective_to_products_table.php
            $table->boolean('is_embeded')->nullable(); // From 2022_06_01_112100_add_is_embeded_to_products_table.php
            $table->text('variant_option')->nullable(); // From 2022_07_19_115504_add_variant_data_to_products_table.php
            $table->text('variant_value')->nullable(); // From 2022_07_19_115504_add_variant_data_to_products_table.php

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
        Schema::dropIfExists('products');
    }
}
