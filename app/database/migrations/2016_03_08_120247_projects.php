<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function($table){
			$table->increments('id');
			$table->string('name','100');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('data_room_id');
			$table->integer('updateby');
			$table->enum('role', ['admin', 'view','downloded'])->default('view');
			$table->enum('status', ['0', '1'])->default('1');
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('data_room_id')->references('id')->on('data_room')->onUpdate('cascade')->onDelete('cascade');
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
