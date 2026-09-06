<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentWithCreditCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_with_credit_card', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id')->index();
            $table->integer('customer_id')->nullable()->index();
            $table->string('customer_stripe_id')->nullable();
            $table->string('charge_id');
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
        Schema::dropIfExists('payment_with_credit_card');
    }
}
