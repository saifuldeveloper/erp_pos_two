<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('variant_id');
            $table->integer('position');
            $table->string('item_code');
            $table->double('additional_price')->nullable();
            $table->timestamps();

            $table->index('product_id');
            $table->index('variant_id');
            $table->index('item_code');
            $table->index(['product_id', 'variant_id']);
            $table->double('qty'); // From 2019_11_25_134041_add_qty_to_product_variants_table.php
            $table->double('additional_cost')->nullable(); // From 2022_07_25_194300_add_additional_cost_to_product_variants_table.php

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
