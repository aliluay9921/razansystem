<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class posation_avillable extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    protected $fillable = [
        'countary_id', 'image',
    ];
    protected $dates = ['deleted_at'];

    public function countaries()
    {
        return $this->hasMany('App\Models\Countary', 'countary_id');
    }
}
