<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\Uuids;

class User extends Authenticatable

{
    use HasFactory, Notifiable, Uuids;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'PhoneNumber',
        'UserName', 'status',
        'password', 'active',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\User', 'user_id');
    }

    public function firbasetokens()
    {
        return $this->hasMany('App\Models\firbasetokens', 'user_id');
    }
    public function notifications()
    {
        return $this->hasMany('App\Models\Notifications', 'from_user');
    }
}