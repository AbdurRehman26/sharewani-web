<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGlobalSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('global_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('key', 45);
			$table->integer('type');
			$table->text('value', 65535);
			$table->timestamps();
			$table->softDeletes();
			$table->boolean('is_active')->nullable();
			$table->text('options', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('global_settings');
	}

}
