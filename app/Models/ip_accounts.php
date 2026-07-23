<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // << importante
use Illuminate\Notifications\Notifiable;

class IpAccount extends Authenticatable
{
    use Notifiable;

    protected $table = 'ip_accounts';

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'contact',
        'address',
        'tribe',
        'leader',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
