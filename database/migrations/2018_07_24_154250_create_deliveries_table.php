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
            $table->string('reference_no');
            $table->integer('sale_id');
            $table->text('address');
            $table->string('delivered_by')->nullable();
            $table->string('recieved_by')->nullable();
            $table->string('file')->nullable();
            $table->string('note')->nullable();
            $table->string('courier_tracking_id')->nullable();
            $table->string('status');
            $table->integer('user_id')->nullable(); // From 2020_09_26_130426_add_user_id_to_deliveries_table.php
            $table->integer('courier_id')->nullable(); // From 2023_07_23_174343_add_courier_id_to_deliveries_table.php

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
        Schema::dropIfExists('deliveries');
    }
}
