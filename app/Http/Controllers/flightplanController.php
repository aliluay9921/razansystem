<?php

namespace App\Http\Controllers;

use App\Events\NotificationsEvent;

use App\Models\User;
use App\Models\Flightplan;
use App\Traits\sendresponse;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\Order;
use App\Traits\paging;
use Illuminate\Support\Facades\Validator;

class flightplanController extends Controller
{
    use sendresponse, paging;

    public function getselected()
    {

        $get = Flightplan::where('order_id', $_GET['order_id'])->where('selected', true);
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get flightplan selected true', [], $res["model"], null, $res["count"]);
    }
    public function get()
    {

        $get = Flightplan::where('order_id', $_GET['order_id'])->with('order');
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get all flightplan', [], $res["model"], null, $res["count"]);
    }
    public function store(Request $request)
    {
        $requests = $request->json()->all();
        $validator = Validator::make($requests, [
            '*'             => 'required|array',
            '*.order_id'    => 'required',
            '*.price'       => 'required|Numeric',
            '*.flight_id'   => 'required',
            '*.note'        => 'required',
            '*.Time_to_go'        => 'required',
            '*.Arrival_time' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }
        // الركوست اجة بي اكثر من مرة يدخل لازم اسوي لوب عليه حتى اكدر اشغلة
        // $employee=User::select('id','status')->where('status',1)->first();
        $order = Order::select('user_id')->where('id', $requests[0]['order_id'])->first();

        foreach ($requests as $request) {
            $store = Flightplan::create($request);
        }
        $notification =  Notifications::create([
            'type'        => 1,
            'name'        => 'رد طلب حجز',
            'description' => 'تم انشاء رد الحجز ',
            'order_id'    => $requests[0]['order_id'],
            'to_user'    => $order->user_id,
            'from_user'     => auth()->user()->id,
            'seen'  => 0
        ]);
        $get = Notifications::find($notification->id);
        broadcast(new NotificationsEvent($get));
        return $this->sendresponse(200, 'insert successfuly Flightpla', [], $store);
    }

    public function selected(Request $request)
    {
        if (Flightplan::where("id", $request->id)->where("selected", true)->get()->count() == 0) {
            $select = Flightplan::find($request->id);
            $select->update([
                'selected' => true
            ]);
            $notification = $select->order->notifications()->where("type", 1)->first();
            $notification->update(
                [
                    'seen' => true
                ]
            );
            return $this->sendresponse(200, 'selected  successfuly Flightpla', [],  $notification);
        } else {
            return $this->sendresponse(300, 'Flight plan already selected', ["error" => ["Flight plan already selected"]], []);
        }
    }
}
