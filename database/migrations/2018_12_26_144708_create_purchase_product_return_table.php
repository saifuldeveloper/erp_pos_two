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
            $table->integer('purchase_unit_id')->index();
            $table->double('net_unit_cost');
            $table->double('discount');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
            $table->integer('variant_id')->nullable()->index();
            $table->integer('product_batch_id')->nullable()->index();
            $table->text('imei_number')->nullable();

            $table->timestamps();
            $table->index('created_at');
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
