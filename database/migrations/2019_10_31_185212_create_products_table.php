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
			$table->boolean('number_of_items')->nullable()->default(1);
			$table->integer('user_id')->nullable();
			$table->integer('color_id')->nullable();
			$table->integer('brand_id')->nullable();
			$table->integer('fabric_age_id')->nullable();
			$table->integer('size_id')->nullable();
			$table->string('original_price', 45)->nullable()->default('1000');
			$table->string('item_code', 45)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('vendor_id')->nullable();
			$table->string('size_length', 45)->nullable();
			$table->string('size_chest', 45)->nullable();
			$table->string('size_collar', 45)->nullable();
			$table->string('size_tummy', 45)->nullable();
			$table->string('size_sleeves', 45)->nullable();
			$table->integer('fabric_brand_id')->nullable();
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
