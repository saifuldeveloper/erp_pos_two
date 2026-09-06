<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_title');
            $table->string('site_logo')->nullable();
            $table->string('currency');
            $table->string('currency_position');
            $table->string('staff_access');
            $table->string('date_format');
            $table->string('theme');
            $table->string('developed_by')->nullable();
            $table->string('invoice_format')->nullable();
            $table->integer('state')->nullable();
            $table->boolean('is_rtl')->nullable();
            $table->integer('decimal')->nullable()->default(2);
            $table->date('expiry_date')->nullable();
            $table->integer('package_id')->nullable()->index();
            $table->boolean('is_zatca')->nullable();
            $table->string('company_name')->nullable();
            $table->string('vat_registration_number')->nullable();
            $table->string("without_stock")->default("no");
            $table->json("modules")->nullable();

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
        Schema::dropIfExists('general_settings');
    }
}
