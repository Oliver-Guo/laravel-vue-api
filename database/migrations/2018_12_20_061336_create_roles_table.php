<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name')->default('')->unique('name');
			$table->string('display_name');
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
		Schema::drop('roles');
	}

}
