<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuthorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('authors', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 100)->comment('名稱');
			$table->text('description', 65535)->nullable()->comment('簡述');
			$table->string('outsite_url')->nullable()->default('')->comment('作者連結');
			$table->string('fb_share')->nullable()->default('');
			$table->string('google_share')->nullable()->default('');
			$table->string('twitter_share')->nullable()->default('');
			$table->boolean('is_online')->nullable()->default(1);
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
		Schema::drop('authors');
	}

}
