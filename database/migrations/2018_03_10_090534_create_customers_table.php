<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_group_id')->index();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable()->index();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->boolean('is_active')->nullable()->index();
            $table->double('deposit')->nullable(); // From 2018_08_25_101354_add_deposit_expense_to_customers_table.php
            $table->double('expense')->nullable(); // From 2018_08_25_101354_add_deposit_expense_to_customers_table.php
            $table->string('tax_no')->nullable(); // From 2019_04_13_101707_add_tax_no_to_customers_table.php
            $table->integer('user_id')->nullable(); // From 2020_11_09_055222_add_user_id_to_customers_table.php
            $table->double('points')->nullable(); // From 2021_06_16_104155_add_points_to_customers_table.php

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
        Schema::dropIfExists('customers');
    }
}
