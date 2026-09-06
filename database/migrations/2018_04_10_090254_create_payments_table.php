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
            $table->integer('sale_id')->nullable()->index();
            $table->string('payment_reference')->index();
            $table->double('amount');
            $table->string('paying_method');
            $table->text('payment_note')->nullable();
            $table->integer('due_payment')->default(0);
            $table->integer('purchase_id')->nullable()->index();
            $table->integer('user_id')->index();
            $table->integer('account_id')->index();
            $table->integer('cash_register_id')->nullable()->index();
            $table->double('used_points')->nullable();
            $table->double('change')->nullable();

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
        Schema::dropIfExists('payments');
    }
}
