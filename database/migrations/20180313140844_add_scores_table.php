<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddScoresTable extends Migration
{
    public function up()
    {
        $this->schema->create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('player_id');
            $table->string('tournament_id');
            $table->string('hole_id');
            $table->string('score');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('scores');
    }
}
