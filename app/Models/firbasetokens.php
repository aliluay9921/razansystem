<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class firbasetokens extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id', 'token',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}