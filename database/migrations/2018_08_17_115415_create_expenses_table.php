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
            $table->integer('account_id')->index();
            $table->integer('user_id')->index();
            $table->integer('cash_register_id')->nullable()->index();

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
