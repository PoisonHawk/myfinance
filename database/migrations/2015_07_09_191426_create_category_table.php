<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('name');
            $table->string('type', 10)->index();
            $table->integer('parent_id', 0);
            $table->timestamp('created_at', '');
            $table->timestamp('updated_at', '');
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
