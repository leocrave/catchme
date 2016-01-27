<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWinnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('winners', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('prize_id')->unsigned();
			$table->integer('week');
			$table->string('type');
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('participants')->onDelete('cascade');
			$table->foreign('prize_id')->references('id')->on('prizes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('winners');
	}

}
