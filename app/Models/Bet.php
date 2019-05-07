<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $table = "bet";

    public static $statusLabels = [
        0 => 'editing',
        1 => 'opened',
        2 => 'bet placed',
        3 => 'canceled',
        4 => 'completed'
    ];

    public function options(){
        return $this->hasMany('App\Models\BetOptions');
    }

    public function players(){
        return $this->hasMany('App\Models\BetPlayers');
    }

    public function getStatusLabelAttribute(){
        return isset(self::$statusLabels[$this->status]) ? self::$statusLabels[$this->status] : 'Unknown Status';
    }

}
