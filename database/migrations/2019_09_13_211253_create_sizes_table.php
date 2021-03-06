<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSizesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function(Blueprint $table)
        {
            $table->integer('id', true);
            $table->string('name')->unique('name_UNIQUE');
            $table->string('code')->unique('code_UNIQUE');
            $table->timestamps();
            $table->softDeletes();
            
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sizes');
    }

}
