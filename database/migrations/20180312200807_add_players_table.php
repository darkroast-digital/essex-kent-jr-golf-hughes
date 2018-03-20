<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPlayersTable extends Migration
{
    public function up()
    {
        $this->schema->create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('age');
            $table->string('gender');
            $table->string('group_id');
            $table->string('image');
            $table->text('bio');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('players');
    }
}
