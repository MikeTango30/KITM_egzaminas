<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'amount',
        'is_main',
    ];

    public function user() {

        return $this->belongsTo(User::class);
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
