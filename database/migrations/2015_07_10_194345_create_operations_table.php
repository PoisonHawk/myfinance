<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function(Blueprint $table){
           $table->increments('id');
           $table->date('created');
           $table->integer('user_id')->index();
           $table->integer('bills_id')->index();
           $table->integer('category_id')->index();
           $table->string('type', 10)->index();
           $table->float('amount');
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
        //
    }
}
