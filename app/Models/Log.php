<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
class Log extends Model
{
    use HasFactory,Uuids;

    protected $fillable = [
        'order','type',
        'issuer_id'
    ];
}
