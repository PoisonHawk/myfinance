<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSavingsColumnsToBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function($table){
			$table->smallinteger('saving_account')->default(0);	
			$table->float('saving_amount')->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('bills', function($table){
			$table->drop('saving_account');
			$table->drop('saving_amount');
		});
    }
}
