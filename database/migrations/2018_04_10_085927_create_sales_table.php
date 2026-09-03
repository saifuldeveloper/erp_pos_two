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
            $table->integer('user_id')->index(); // From 2018_06_21_094155_add_user_id_to_sales_table.php
            $table->integer('coupon_id')->nullable(); // From 2018_10_27_090857_add_coupon_to_sales_table.php
            $table->double('coupon_discount')->nullable(); // From 2018_10_27_090857_add_coupon_to_sales_table.php
            $table->integer('cash_register_id')->nullable(); // From 2020_10_13_155019_add_cash_register_id_to_sales_table.php
            $table->string('order_discount_type')->nullable(); // From 2022_02_05_174210_add_order_discount_type_and_value_to_sales_table.php
            $table->double('order_discount_value')->nullable(); // From 2022_02_05_174210_add_order_discount_type_and_value_to_sales_table.php
            $table->integer('currency_id')->nullable()->default(null); // From 2023_02_23_125656_alter_table_sales.php
            $table->double('exchange_rate')->nullable()->default(null); // From 2023_02_23_125656_alter_table_sales.php
            $table->integer('table_id')->nullable(); // From 2023_05_29_115301_add_table_id_to_sales_table.php
            $table->integer('queue')->nullable(); // From 2023_05_31_165049_add_queue_no_to_sales_table.php

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
