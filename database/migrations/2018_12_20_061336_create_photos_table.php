<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('photos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('imageable_id')->comment('對應表id');
			$table->string('imageable_type', 100)->comment('對應表');
			$table->string('name', 100)->unique('name')->comment('檔名');
			$table->string('orig_name')->comment('原始檔名');
			$table->string('type', 100)->comment('圖片類型');
			$table->string('path', 200)->comment('存放路徑');
			$table->string('size', 100)->default('0')->comment('圖大小');
			$table->integer('width')->comment('圖寬');
			$table->integer('height')->comment('圖高');
			$table->integer('sort')->default(9999);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('photos');
	}

}
