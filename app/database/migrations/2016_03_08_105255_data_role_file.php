<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataRoleFile extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_role_file', function($table){
			$table->increments('id');
			$table->unsignedInteger('userid');
			$table->unsignedInteger('folderid');
			$table->string('filename','255');
			$table->string('file_type','255');
			$table->string('file_size','255');
			$table->string('file_resolution','255');
			$table->string('title','100');
			$table->string('alt','50');
			$table->enum('camefrom', ['direct', 'search engine']);
			$table->string('source','50');
			$table->timestamps();
			$table->foreign('folderid')->references('id')->on('folder')->onUpdate('cascade')->onDelete('cascade');
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
