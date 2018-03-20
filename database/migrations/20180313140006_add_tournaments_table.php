<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTournamentsTable extends Migration
{
    public function up()
    {
        $this->schema->create('tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('holes');
            $table->string('par')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('tournaments');
    }
}
