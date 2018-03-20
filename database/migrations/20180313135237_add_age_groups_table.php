<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAgeGroupsTable extends Migration
{
    public function up()
    {
        $this->schema->create('age_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('holes_played');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('age_groups');
    }
}
