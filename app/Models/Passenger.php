<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Uuids;

class Passenger extends Model
{
    use HasFactory, Uuids;
    use SoftDeletes;

    protected $fillable = [
        'order_id', 'type',
        'first_name', 'last_name', 'gender',
        'passport_No', 'picture_passport', 'birth_day'
    ];
    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function getgenderAttribute($val)
    {
        return $val == 1 ? 'male' : 'female';
    }

    public function gettypeAttribute($val)
    {
        if ($val == 0) {
            return 'infant';
        } elseif ($val == 1) {
            return 'child';
        } else return 'adult';
    }
    public function setbirth_dayAttribute($value)
    {
        $this->attributes['birth_day'] = strtr($value, array('٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }
    public function setpassport_NoAttribute($value)
    {
        $this->attributes['passport_No'] = strtr($value, array('٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }
}