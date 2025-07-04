<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pairing extends Model
{
    protected $table = 'pairings';
    public $timestamps = false;

    protected $fillable = [
        'kickoff',
        'my_country_id',
        'enemy_country_id'
    ];

    protected $casts = [
        'kickoff' => 'datetime',
    ];

    public function myCountry()
    {
        return $this->belongsTo(Country::class, 'my_country_id');
    }

    public function enemyCountry()
    {
        return $this->belongsTo(Country::class, 'enemy_country_id');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }
}