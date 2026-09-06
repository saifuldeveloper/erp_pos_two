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
            $table->string('phone');
            $table->string('company_name')->nullable();
            $table->integer('role_id')->index();
            $table->boolean('is_active')->index();
            $table->boolean('is_deleted');
            $table->integer('biller_id')->nullable()->index();
            $table->integer('warehouse_id')->nullable()->index();

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
        Schema::dropIfExists('users');
    }
}
