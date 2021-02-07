<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifications extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'type', 'name',
        'description', 'order_id',
        'to_user', 'from_user',
        'seen',
    ];
    protected $appends = ['flight_line'];

    public function getFlightLineAttribute()
    {
        $order = Order::find($this->attributes['order_id']);
        if ($order == null)
            return null;
        $flightplan = $order->flightplans()->where('selected', true)->first();
        if ($flightplan == null) return null;
        return  Flightline::find($flightplan->flight_id);
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    protected $casts = [
        'seen' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'from_user');
    }
}
