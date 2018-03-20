<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHolesTable extends Migration
{
    public function up()
    {
        $this->schema->create('holes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hole');
            $table->string('par')->nullable();
            $table->string('tournament_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('holes');
    }
}
