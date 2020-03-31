<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'account_id',
        'in',
        'out',
        'message',
        'amount'
    ];

    public function user() {

        return $this->belongsTo(Account::class);
    }
}
