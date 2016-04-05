<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Folder extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('folder', function($table){
			$table->increments('id');
			$table->string('foldername','255');
			$table->integer('parentid');
			$table->integer('userid');
			$table->integer('projectid');
			$table->integer('dataroomid');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
