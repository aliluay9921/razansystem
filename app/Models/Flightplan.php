<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Flightplan extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'order_id', 'price',
        'flight_id', 'note',
        'selected', 'active', 'Time_to_go', 'Arrival_time'
    ];
    protected $casts = [
        "selected" => "boolean"
    ];
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
    public function flghtline()
    {
        return $this->belongsTo('App\Models\Flightline');
    }
}