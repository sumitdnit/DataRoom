<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FileTaggs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('file_tags', function($table){
			$table->increments('id');
			$table->unsignedInteger('userid');
			$table->integer('fileid');
			$table->unsignedInteger('folderid');
			$table->string('tag','255');
			$table->timestamps();
			$table->foreign('folderid')->references('folderid')->on('data_role_file')->onUpdate('cascade')->onDelete('cascade');
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
