<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateColorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function(Blueprint $table)
        {
            $table->integer('id', true);
            $table->string('name')->unique('name_UNIQUE');
            $table->timestamps();
            $table->string('deleted_at', 6)->nullable();
            $table->integer('parent_id')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('colors');
    }

}