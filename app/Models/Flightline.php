<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Flightline extends Model
{
    use HasFactory,Uuids;

    protected $fillable = [
        'name','image',
        'active'
    ];
}
