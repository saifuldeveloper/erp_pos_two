<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->nullable();
            $table->string('payment_reference');
            $table->double('amount');
            $table->string('paying_method');
            $table->text('payment_note')->nullable();
            $table->integer('due_payment')->default(0);
            $table->integer('purchase_id')->nullable(); // From 2018_05_13_082847_add_payment_id_and_change_sale_id_to_payments_table.php
            $table->integer('user_id'); // From 2018_07_11_102334_add_user_id_to_payments_table.php
            $table->integer('account_id'); // From 2018_12_19_103941_add_account_id_to_payments_table.php
            $table->integer('cash_register_id')->nullable(); // From 2020_10_17_212338_add_cash_register_id_to_payments_table.php
            $table->double('used_points')->nullable(); // From 2021_06_17_101057_add_used_points_to_payments_table.php
            $table->double('change')->nullable(); // From 2024_10_07_191349_add_change_to_payments_table.php

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
        Schema::dropIfExists('payments');
    }
}
