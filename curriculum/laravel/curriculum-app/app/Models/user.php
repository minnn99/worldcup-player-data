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

    // パスワードを自動的にハッシュ化する
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // 国とのリレーションを定義
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // 管理者かどうかを判定する
    public function isAdmin()
    {
        return $this->role === 0;
    }

    // 一般ユーザーかどうかを判定する
    public function isUser()
    {
        return $this->role === 1;
    }

    // 役割のテキストを返す
    public function getRoleTextAttribute()
    {
        return $this->role === 0 ? '管理ユーザー' : '一般ユーザー';
    }
}
