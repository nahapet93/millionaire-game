<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('game_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->tinyInteger('is_correctly_answered')->default(0);
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games_questions', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['question_id']);
            $table->dropIfExists();
        });
    }
}
