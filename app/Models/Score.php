<?php

namespace App\Models;

use App\Models\Score;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'player_id',
        'tournament_id',
        'hole_id',
        'score'
    ];

    public function Player()
    {
        return $this->belongsTo(Player::class);
    }

    public function Tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function Hole()
    {
        return $this->belongsTo(Hole::class);
    }

}