<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    protected $fillable = [
        'name',
        'holes_played'
    ];

    public function Players()
    {
        return $this->hasMany(Player::class);
    }

    public function Tournaments()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function tournList()
    {
        $tournaments = Tournament::all();
        $tournaments = Tournament::where('holes', $this->holes_played)->get();

        return $tournaments;
    }
}
