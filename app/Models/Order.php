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
        'returndate', 'user_id'
    ];
    public function getcabinAttribute($val)
    {
        return $val == 1 ? "رجال اعمال " : "اقتصادي";
    }

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
}