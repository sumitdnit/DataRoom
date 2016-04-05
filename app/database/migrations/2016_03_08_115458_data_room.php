<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataRoom extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_room', function($table){
			$table->increments('id');
			$table->string('name','100');
			$table->string('company','100');
			$table->string('photo','255');
			$table->text('description');
			$table->unsignedInteger('user_id');
			$table->enum('role', ['admin', 'view','downloded'])->default('view');
			$table->enum('status', ['0', '1'])->default('1');
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
