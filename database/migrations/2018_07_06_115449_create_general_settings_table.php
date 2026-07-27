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
            $table->string('currency'); // From 2018_09_10_051254_add_currency_to_general_settings_table.php
            $table->string('currency_position'); // From 2018_11_07_070155_add_currency_position_to_general_settings_table.php
            $table->string('staff_access'); // From 2019_01_27_160956_add_three_columns_to_general_settings_table.php
            $table->string('date_format'); // From 2019_01_27_160956_add_three_columns_to_general_settings_table.php
            $table->string('theme'); // From 2019_01_27_160956_add_three_columns_to_general_settings_table.php
            $table->string('developed_by')->nullable(); // From 2020_10_21_121632_add_developed_by_to_general_settings_table.php
            $table->string('invoice_format')->nullable(); // From 2020_11_17_054806_add_invoice_format_to_general_settings_table.php
            $table->integer('state')->nullable(); // From 2020_11_17_054806_add_invoice_format_to_general_settings_table.php
            $table->boolean('is_rtl')->nullable(); // From 2021_10_12_205146_add_is_rtl_to_general_settings_table.php
            $table->integer('decimal')->nullable()->default(2); // From 2023_01_18_125040_alter_table_general_settings.php
            $table->date('expiry_date')->nullable(); // From 2023_01_25_145309_add_expiry_date_to_general_settings_table.php
            $table->integer('package_id')->nullable(); // From 2023_02_26_124100_add_package_id_to_general_settings_table.php
            $table->boolean('is_zatca')->nullable(); // From 2023_05_13_125424_add_zatca_to_general_settings_table.php
            $table->string('company_name')->nullable(); // From 2023_05_13_125424_add_zatca_to_general_settings_table.php
            $table->string('vat_registration_number')->nullable(); // From 2023_05_13_125424_add_zatca_to_general_settings_table.php
            $table->string("without_stock")->default("no"); // From 2023_09_10_134503_add_without_stock_to_general_settings_table.php
            $table->json("modules")->nullable(); // From 2023_09_26_211542_add_modules_to_general_settings_table.php

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
        Schema::dropIfExists('general_settings');
    }
}
