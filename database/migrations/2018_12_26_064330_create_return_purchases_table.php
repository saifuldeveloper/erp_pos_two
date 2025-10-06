<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnPurchasesTable extends Migration
{

    public function up()
    {
        Schema::create('return_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no');
            $table->integer('supplier_id')->nullable();
            $table->integer('warehouse_id');
            $table->integer('user_id');
            $table->integer('account_id');
            $table->integer('item')->default(0);
            $table->integer('total_qty')->default(0);
            $table->double('total_discount')->default(0);
            $table->double('total_tax')->default(0);
            $table->double('total_cost')->default(0);
            $table->double('order_tax_rate')->nullable();
            $table->double('order_tax')->nullable();
            $table->double('grand_total')->default(0);
            $table->string('document')->nullable();
            $table->text('return_note')->nullable();
            $table->text('staff_note')->nullable();
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
        Schema::dropIfExists('return_purchases');
    }
}
