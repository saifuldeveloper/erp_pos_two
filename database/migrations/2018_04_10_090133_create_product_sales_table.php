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
            $table->integer('sale_unit_id')->index();
            $table->double('net_unit_price');
            $table->double('discount');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
            $table->integer('variant_id')->nullable()->index();
            $table->integer('product_batch_id')->nullable()->index();
            $table->text('imei_number')->nullable();
            $table->double('return_qty')->default(0);

            $table->timestamps();
            $table->index('created_at');
            $table->index(['product_id', 'created_at']);
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
