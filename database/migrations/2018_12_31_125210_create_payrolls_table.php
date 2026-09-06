<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payroll_type_id')->index();
            $table->string('reference_no')->index();
            $table->integer('employee_id')->index();
            $table->integer('account_id')->index();
            $table->integer('user_id')->index();
            $table->double('salary');
            $table->double('amount');
            $table->string('paying_method');
            $table->text('note')->nullable();

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
        Schema::dropIfExists('payrolls');
    }
}
