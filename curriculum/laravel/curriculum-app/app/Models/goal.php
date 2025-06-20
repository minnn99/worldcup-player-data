<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['pairing_id', 'player_id', 'goal_time'];
    public $timestamps = false;

    public function pairing()
    {
        return $this->belongsTo(Pairing::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}