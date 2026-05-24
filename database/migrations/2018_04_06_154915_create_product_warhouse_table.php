<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductWarhouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('product_batch_id')->nullable();
            $table->integer('warehouse_id')->unsigned();
            $table->integer('variant_id')->nullable()->unsigned();
            $table->text('imei_number')->nullable();
            $table->double('qty', 15, 2)->default(0);
            $table->double('price', 15, 2)->nullable();
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
        Schema::dropIfExists('product_warehouse');
    }
}
