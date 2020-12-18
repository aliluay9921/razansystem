<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifications extends Model
{
    use HasFactory,Uuids;

    protected $fillable = [
        'type','name',
        'description','order_id',
        'to_user','from_user',
        'seen',
    ];

}
