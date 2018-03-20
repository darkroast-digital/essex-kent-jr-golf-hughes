<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'holes',
        'par',
        'date'
    ];

    public function Scores()
    {
        return $this->hasMany(Score::class);
    }

    public function Holes()
    {
        return $this->hasMany(Hole::class);
    }

    public function Players()
    {
        return $this->hasMany(Player::class);
    }

    public function AgeGroups()
    {
        return $this->hasMany(AgeGroup::class);
    }
}