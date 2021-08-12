<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Order extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'from', 'to',
        'cabin', 'active',
        'expired', 'fromdate',
        'returndate', 'user_id', 'pnr'
    ];


    public function passengers()
    {
        return $this->hasMany('App\Models\Passenger', 'order_id');
    }

    public function ticket()
    {
        return $this->hasOne('App\Models\ticket', 'order_id');
    }
    public function flightplans()
    {
        return $this->hasMany('App\Models\Flightplan', 'order_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notifications', 'order_id');
    }
    public function fromLocation()
    {
        return $this->belongsTo('App\Models\countary', 'from');
    }
    public function toLocation()
    {
        return $this->belongsTo('App\Models\countary', 'to');
    }
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function setfromdateAttribute($value)
    {
        $this->attributes['fromdate'] = strtr($value, array('٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }
    public function setreturndateAttribute($value)
    {
        $this->attributes['returndate'] = strtr($value, array('٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }
}
