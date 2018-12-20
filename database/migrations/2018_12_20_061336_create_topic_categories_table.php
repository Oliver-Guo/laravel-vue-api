<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topic_categories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->boolean('is_online')->default(0);
			$table->integer('sort')->default(9999);
			$table->bigInteger('created_at')->nullable();
			$table->bigInteger('updated_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('topic_categories');
	}

}
