<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permission_groups', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('group_name', 50)->default('');
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
		Schema::drop('permission_groups');
	}

}
