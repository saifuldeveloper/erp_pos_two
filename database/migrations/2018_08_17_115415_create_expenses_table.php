<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no')->index();
            $table->integer('expense_category_id')->index();
            $table->integer('warehouse_id')->index();
            $table->double('amount');
            $table->text('note')->nullable();
            $table->integer('account_id')->index(); // From 2018_12_20_065900_add_account_id_to_expenses_table.php
            $table->integer('user_id')->index(); // From 2019_01_01_062708_add_user_id_to_expenses_table.php
            $table->integer('cash_register_id')->nullable(); // From 2020_10_18_124200_add_cash_register_id_to_expenses_table.php

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
        Schema::dropIfExists('expenses');
    }
}
