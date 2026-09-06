<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->index();
            $table->string('type')->nullable();
            $table->string('barcode_symbology')->nullable();
            $table->integer('brand_id')->nullable()->index();
            $table->integer('category_id')->index();
            $table->integer('unit_id')->index();
            $table->integer('purchase_unit_id')->index();
            $table->integer('sale_unit_id')->index();
            $table->double('cost')->nullable();
            $table->double('price');
            $table->double('qty')->nullable();
            $table->double('alert_quantity')->nullable();
            $table->tinyInteger('promotion')->nullable();
            $table->string('promotion_price')->nullable();
            $table->date('starting_date')->nullable();
            $table->date('last_date')->nullable();
            $table->integer('tax_id')->nullable()->index();
            $table->integer('tax_method')->nullable();
            $table->longText('image')->nullable();
            $table->tinyInteger('featured')->nullable()->index();
            $table->text('product_details')->nullable();
            $table->boolean('is_active')->nullable()->index();
            $table->string('file')->nullable();
            $table->string('product_list')->nullable();
            $table->string('qty_list')->nullable();
            $table->string('price_list')->nullable();
            $table->boolean('is_variant')->nullable();
            $table->boolean('is_diffPrice')->nullable();
            $table->boolean('is_batch')->nullable();
            $table->string('variant_list')->nullable();
            $table->boolean('is_imei')->nullable();
            $table->double('daily_sale_objective')->nullable();
            $table->boolean('is_embeded')->nullable();
            $table->text('variant_option')->nullable();
            $table->text('variant_value')->nullable();

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
        Schema::dropIfExists('products');
    }
}
