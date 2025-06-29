<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $table = 'goals';
    public $timestamps = false;

    protected $fillable = [
        'pairing_id',
        'player_id',
        'goal_time'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function pairing()
    {
        return $this->belongsTo(Pairing::class);
    }
}