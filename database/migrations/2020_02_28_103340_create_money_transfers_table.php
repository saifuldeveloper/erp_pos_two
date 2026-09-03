<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('money_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no')->index();
            $table->integer('from_account_id')->index();
            $table->integer('to_account_id')->index();
            $table->double('amount');
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
        Schema::dropIfExists('money_transfers');
    }
}
