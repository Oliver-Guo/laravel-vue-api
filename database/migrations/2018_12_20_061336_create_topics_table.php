<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topics', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('topic_category_id')->nullable()->comment('topic_categories');
			$table->integer('author_id')->nullable()->comment('authors');
			$table->string('title')->comment('標題');
			$table->text('description', 65535)->nullable()->comment('簡述');
			$table->boolean('is_online')->default(0);
			$table->integer('sort')->default(9999);
			$table->bigInteger('onlined_at')->nullable()->comment('預定上稿時間');
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
		Schema::drop('topics');
	}

}
