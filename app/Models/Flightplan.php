<?php

namespace App\Models;

use App\Models\Order;
use App\Traits\Uuids;
use App\Models\Flightline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(Order::class, "order_id");
    }
    public function flghtline()
    {
        return $this->belongsTo(Flightline::class, "flight_id");
    }
}