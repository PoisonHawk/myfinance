<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('purchases', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->string('name', 255);
          $table->integer('amount');
          $table->smallInteger('priority');
          $table->integer('category_id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchases');
    }
}
