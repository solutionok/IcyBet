<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetPlayers extends Model
{
    protected $table = 'bet_players';
    public $timestamps = false;

    protected $fillable = [
        'bet_id'
    ];

}
