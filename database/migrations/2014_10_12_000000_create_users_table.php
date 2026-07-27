<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('phone'); // From 2018_06_02_073430_add_columns_to_users_table.php
            $table->string('company_name')->nullable(); // From 2018_06_02_073430_add_columns_to_users_table.php
            $table->integer('role_id'); // From 2018_06_02_073430_add_columns_to_users_table.php
            $table->boolean('is_active'); // From 2018_06_02_073430_add_columns_to_users_table.php
            $table->boolean('is_deleted'); // From 2018_06_23_082427_add_is_deleted_to_users_table.php
            $table->integer('biller_id')->nullable(); // From 2018_10_22_084118_add_biller_and_store_id_to_users_table.php
            $table->integer('warehouse_id')->nullable(); // From 2018_10_22_084118_add_biller_and_store_id_to_users_table.php

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
        Schema::dropIfExists('users');
    }
}
