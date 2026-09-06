<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no')->index();
            $table->integer('sale_id')->index();
            $table->text('address');
            $table->string('delivered_by')->nullable();
            $table->string('recieved_by')->nullable();
            $table->string('file')->nullable();
            $table->string('note')->nullable();
            $table->string('courier_tracking_id')->nullable()->index();
            $table->string('status')->index();
            $table->integer('user_id')->nullable()->index();
            $table->integer('courier_id')->nullable()->index();

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
        Schema::dropIfExists('deliveries');
    }
}
