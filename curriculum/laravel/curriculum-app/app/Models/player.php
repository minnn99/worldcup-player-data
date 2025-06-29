<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';
    public $timestamps = false;

    protected $fillable = [
        'country_id',
        'uniform_num',
        'position',
        'name',
        'club',
        'birth',
        'height',
        'weight',
        'del_flg'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function scopeActive($query)
    {
        return $query->where('del_flg', 0);
    }
}