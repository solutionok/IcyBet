<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetOptions extends Model
{
    protected $table = 'bet_options';
    public $timestamps = false;

    protected $fillable = [
        'bet_id'
    ];
}
