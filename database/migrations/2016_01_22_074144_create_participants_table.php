<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('social_id');
            $table->string('username');
            $table->string('email')->nullable();
            $table->string('ic')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('participateWeek')->nullable();
            $table->integer('question_id')->unsigned();
            $table->string('answer')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('isInstantWinner')->default(false);
            $table->boolean('isWeekWinner')->default(false);
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('participants');
    }
}
