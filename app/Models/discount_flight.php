<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class discount_flight extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'flightline_id', 'details',
        'code_discount', 'discount',
        'miximum_number', 'minimum_number',
        'current_user', 'expair',
        'fromdate', 'returndate', 'type',
        'from', 'to', 'active'
    ];
    protected $dates = ['deleted_at'];
}
