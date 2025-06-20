<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pairing extends Model
{
    protected $fillable = [
        'match_name',
        // Add other relevant fields
    ];

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }
}