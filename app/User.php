<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {

        static::created(function ($user) {
            $faker = Faker::create();

            $accountMain = Account::create([
                'user_id' => $user->id,
                'number' => $faker->iban('LT'),
                'amount' => 500,
                'is_main' => true
            ]);

            $account = Account::create([
                'user_id' => $user->id,
                'number' => $faker->iban('LT'),
                'amount' => 0,
                'is_main' => false
            ]);
        });
    }
}
