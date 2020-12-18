<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Uuids;
class Passenger extends Model
{
    use HasFactory,Uuids;
    use SoftDeletes;

    protected $fillable = [
        'order_id','type',
        'name','gender',
        'passport_No','picture_passport'
    ];
    protected $dates=['deleted_at'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    
    
}
