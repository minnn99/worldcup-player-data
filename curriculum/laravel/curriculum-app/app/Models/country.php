<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'ranking',
        'group_name'
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function myPairings()
    {
        return $this->hasMany(Pairing::class, 'my_country_id');
    }

    public function enemyPairings()
    {
        return $this->hasMany(Pairing::class, 'enemy_country_id');
    }
}