<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_adjustments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adjustment_id');
            $table->integer('product_id');
            $table->double('qty');
            $table->string('action');
            $table->integer('variant_id')->nullable(); // From 2021_02_10_074859_add_variant_id_to_product_adjustments_table.php

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
        Schema::dropIfExists('product_adjustments');
    }
}
