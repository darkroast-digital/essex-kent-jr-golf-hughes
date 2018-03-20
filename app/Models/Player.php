<?php

namespace App\Models;

use App\Models\Score;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'fname',
        'lname',
        'age',
        'gender',
        'age_group_id',
        'image',
        'bio'
    ];

    public function Scores()
    {
        return $this->hasMany(Score::class);
    }

    public function AgeGroup()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function Tournaments()
    {
        return $this->hasMany(Tournament::class);
    }
}