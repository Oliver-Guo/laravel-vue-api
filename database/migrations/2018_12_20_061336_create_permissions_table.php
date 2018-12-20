<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->integer('permission_group_id')->nullable();
			$table->string('display_type')->default('');
			$table->string('display_name')->default('');
			$table->integer('sort')->default(999);
			$table->string('description')->default('');
			$table->integer('created_user')->default(0);
			$table->bigInteger('created_at')->nullable();
			$table->integer('updated_user')->default(0);
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
		Schema::drop('permissions');
	}

}
