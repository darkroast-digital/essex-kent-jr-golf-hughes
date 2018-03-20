<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hole extends Model
{
    protected $fillable = [
        'hole',
        'par',
        'tournament_id'
    ];

    public function Scores()
    {
        return $this->hasMany(Score::class);
    }

    public function Tournaments()
    {
        return $this->belongsTo(Tournament::class);
    }
}
