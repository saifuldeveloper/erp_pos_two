<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no')->index();
            $table->integer('customer_id')->index();
            $table->integer('warehouse_id')->index();
            $table->integer('biller_id')->index();
            $table->integer('item');
            $table->double('total_qty');
            $table->double('total_discount');
            $table->double('total_tax');
            $table->double('total_price');
            $table->double('grand_total');
            $table->double('order_tax_rate')->nullable();
            $table->double('order_tax')->nullable();
            $table->double('order_discount')->nullable();
            $table->double('shipping_cost')->nullable();
            $table->integer('sale_status')->index();
            $table->string('sale_type')->nullable();
            $table->integer('payment_status')->index();
            $table->string('document')->nullable();
            $table->double('paid_amount')->nullable();
            $table->text('payment_note')->nullable();
            $table->text('sale_note')->nullable();
            $table->text('staff_note')->nullable();
            $table->integer('user_id')->index();
            $table->integer('coupon_id')->nullable()->index();
            $table->double('coupon_discount')->nullable();
            $table->integer('cash_register_id')->nullable()->index();
            $table->string('order_discount_type')->nullable();
            $table->double('order_discount_value')->nullable();
            $table->integer('currency_id')->nullable()->default(null)->index();
            $table->double('exchange_rate')->nullable()->default(null);
            $table->integer('table_id')->nullable()->index();
            $table->integer('queue')->nullable();

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
        Schema::dropIfExists('sales');
    }
}
