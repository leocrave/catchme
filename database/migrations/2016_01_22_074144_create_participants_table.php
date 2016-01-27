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
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('social_id')->nullable();
            $table->string('email')->nullable();
            $table->string('icno')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('isRegistered')->default(false);
            $table->boolean('isFirstTimeUser')->default(false);
            $table->boolean('isInstantWinner')->default(false);
            $table->boolean('isGrandWinner')->default(false);
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
        Schema::drop('participants');
    }
}
