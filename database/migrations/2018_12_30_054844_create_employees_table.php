<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone_number');
            $table->integer('user_id')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->decimal('salary', 15, 2)->nullable();
            $table->json('salary_history')->nullable();
            $table->boolean('is_active');
            $table->integer('department_id'); // From 2018_12_31_150446_add_department_id_to_employees_table.php
            $table->string('staff_id', 191)->nullable(); // From 2023_08_12_124016_add_staff_id_to_employees_table.php

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
        Schema::dropIfExists('employees');
    }
}
