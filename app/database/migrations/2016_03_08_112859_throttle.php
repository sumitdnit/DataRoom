<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Throttle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('throttle', function($table){
			$table->increments('id');
			$table->unsignedInteger('userid');
			$table->string('ip_address','100');
			$table->integer('attempts');
			$table->tinyInteger('suspended');
			$table->tinyInteger('banned');
			$table->timestamp('last_attempt_at');
			$table->timestamp('suspended_at');
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
