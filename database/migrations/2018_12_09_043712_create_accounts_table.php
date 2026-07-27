<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_no');
            $table->string('name');
            $table->double('initial_balance')->nullable();
            $table->double('total_balance');
            $table->text('note')->nullable();
            $table->boolean('is_active');
            $table->boolean('is_default')->nullable(); // From 2018_12_17_112253_add_is_default_to_accounts_table.php

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
        Schema::dropIfExists('accounts');
    }
}
