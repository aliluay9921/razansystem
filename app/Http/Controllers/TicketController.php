<?php

namespace App\Http\Controllers;

use App\Events\NotificationsEvent;
use Exception;
use App\Models\Order;
use App\Models\ticket;
use App\Models\Flightplan;
use App\Models\Notifications;
use App\Traits\paging;
use App\Traits\sendresponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    use sendresponse, paging;

    public function getAll()
    {

        $get = ticket::where('active', false);
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get successfully ticket all ', [], $res["model"], null, $res["count"]);
    }
    public function getTicketPnr()
    {
        $get = ticket::with(['orders' => function ($q) {
            $q->whereNotNull('PNR');
        }]);
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get successfully ticket has PNR', [], $res["model"], null, $res["count"]);
    }

    public function get()
    {
        $get = ticket::where('order_id', $_GET['order_id']);
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get successfully ticket', [], $res["model"], null, $res["count"]);
    }
    public function store(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'order_id' => 'required|exists:orders,id',
            'ticket_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }
        $order = Order::find($request['order_id']);
        $flightplan = $order->flightplans()->where('selected', true)->first();
        if ($order->active == 0) {
            $create = ticket::create([
                'ticket_id' => $request['ticket_id'],
                'order_id' => $request['order_id'],
                'flightline_id' => $flightplan->flight_id
            ]);
            $create = ticket::find($create->id);
            $order->update(['active' => 1]);
            $user_id = $order->user_id;
            $notification =  Notifications::create([
                'type' => 4,
                'name' => '  تم انشاء تكت',
                'description' => 'تم انشاء تكت',
                'order_id' => $order->id,
                'to_user' => $user_id,
                'from_user' => auth()->user()->id,
                'seen' => 0
            ]);
            $get = Notifications::find($notification->id);
            broadcast(new NotificationsEvent($get));
            return $this->sendresponse(200, 'insert successfully ticket', [], $create);
        } else {
            return $this->sendresponse(401, 'this order has ticket ', [], []);
        }
    }

    public function Issue(Request $request)
    {
        $request = $request->json()->all();
        ticket::find($request['id'])->update([
            'active' => true
        ]);
        return $this->sendresponse(200, 'issue ticket  ', [], ticket::find($request['id']));
    }
}