<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no');
            $table->integer('warehouse_id');
            $table->integer('supplier_id')->nullable()->index();
            $table->integer('item');
            $table->integer('total_qty');
            $table->double('total_discount');
            $table->double('total_tax');
            $table->double('total_cost');
            $table->double('order_tax_rate')->nullable();
            $table->double('order_tax', 8, 2)->nullable();
            $table->double('order_discount')->nullable();
            $table->double('shipping_cost')->nullable();
            $table->double('grand_total');
            $table->double('paid_amount');
            $table->integer('status');
            $table->integer('payment_status');
            $table->string('document')->nullable();
            $table->text('note')->nullable();
            $table->integer('user_id')->index(); // From 2018_06_21_101529_add_user_id_to_purchases_table.php
            $table->integer('currency_id')->nullable(); // From 2023_03_27_114320_add_currency_id_and_exchange_rate_to_purchases_table.php
            $table->double('exchange_rate')->nullable(); // From 2023_03_27_114320_add_currency_id_and_exchange_rate_to_purchases_table.php

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
        Schema::dropIfExists('purchases');
    }
}
