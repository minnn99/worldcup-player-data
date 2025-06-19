<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Countryに属するPlayersとのリレーション
    public function players()
    {
        return $this->hasMany(Player::class);
    }
}