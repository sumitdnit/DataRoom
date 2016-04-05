<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationFolderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('folder_relation', function($table){
			$table->increments('id');
			$table->unsignedInteger('folder_id');
			$table->unsignedInteger('user_id');
			$table->enum('role', ['admin', 'upload', 'view', 'downloded'])->default(null);
			$table->unsignedInteger('dataroom_id');
			$table->unsignedInteger('project_id');
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('folder_id')->references('id')->on('project_folder')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('dataroom_id')->references('id')->on('data_room')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
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
