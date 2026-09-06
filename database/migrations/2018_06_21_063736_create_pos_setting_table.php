<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_setting', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->integer('customer_id')->index();
            $table->integer('warehouse_id')->index();
            $table->integer('biller_id')->index();
            $table->integer('product_number');
            $table->string('stripe_public_key')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->boolean('keybord_active');
            $table->string('paypal_live_api_username')->nullable()->default(null);
            $table->string('paypal_live_api_password')->nullable()->default(null);
            $table->string('paypal_live_api_secret')->nullable()->default(null);
            $table->text('payment_options')->nullable()->default(null);
            $table->string('invoice_option',10)->nullable()->default(null);
            $table->boolean('is_table')->default(0);

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
        Schema::dropIfExists('pos_setting');
    }
}
