<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagTopicTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_topic', function(Blueprint $table)
		{
			$table->integer('tag_id')->comment('tags');
			$table->integer('topic_id')->comment('topics');
			$table->primary(['tag_id','topic_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tag_topic');
	}

}
