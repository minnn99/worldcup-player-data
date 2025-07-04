<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false; // created_at, updated_at カラムを使用しない

    protected $fillable = [
        'country_id',
        'email',
        'password',
        'role'
    ];

    // パスワードをシリアライズ時に非表示にする
    protected $hidden = [
        'password'
    ];

    // Countryとのリレーション
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
