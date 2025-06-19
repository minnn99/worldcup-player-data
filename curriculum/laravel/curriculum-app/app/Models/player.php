<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

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

    // Playerが属するCountryとのリレーション
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // 削除されていない選手のみを取得するスコープ
    public function scopeActive($query)
    {
        return $query->where('del_flg', 0);
    }
}