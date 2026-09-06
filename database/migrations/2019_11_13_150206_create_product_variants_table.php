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
            $table->integer('product_id')->index();
            $table->integer('variant_id')->index();
            $table->integer('position');
            $table->string('item_code');
            $table->double('additional_price')->nullable();
            $table->timestamps();
            $table->index('created_at');

            $table->index('item_code');
            $table->index(['product_id', 'variant_id']);
            $table->double('qty');
            $table->double('additional_cost')->nullable();
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
