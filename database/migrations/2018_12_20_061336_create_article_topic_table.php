<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleTopicTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_topic', function(Blueprint $table)
		{
			$table->integer('article_id')->comment('articles');
			$table->integer('topic_id')->comment('topics');
			$table->integer('sort')->default(9999);
			$table->primary(['topic_id','article_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('article_topic');
	}

}
