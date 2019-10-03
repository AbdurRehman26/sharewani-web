<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->string('title')->nullable();
			$table->text('description', 65535)->nullable();
			$table->text('images', 65535)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->boolean('number_of_items')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('category_id')->nullable();
			$table->integer('event_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
