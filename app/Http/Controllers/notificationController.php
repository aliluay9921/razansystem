<?php

namespace App\Http\Controllers;

use App\Events\notifications as EventsNotifications;
use App\Events\AdminNotificationEvent;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\User;
use App\Traits\paging;
use Illuminate\Support\Facades\Validator;
use App\Traits\sendresponse;
use Illuminate\Notifications\Notification;

class notificationController extends Controller
{
    use sendresponse, paging;

    public function get()
    {
        $get = Notifications::where('to_user', auth()->user()->id)->orderByDesc('created_at')->with('order');

        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);

        return $this->sendresponse(200, 'get notification successfuly', [], $res["model"]->append('flight_line'), null, $res["count"]);
    }
    public function getemployee()
    {
        $get = Notifications::where('type', 0)->where("seen", "=", false)->orderByDesc('created_at')->with('order', 'order.passengers', 'order.fromLocation', 'order.toLocation', 'user');
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get notification employee successfuly', [], $res["model"], null, $res["count"]);
    }
    public function getBroadCast()
    {
        $get = Notifications::where('type', 2)->orderByDesc('created_at');
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get notification admin  successfuly', [], $res["model"], null, $res["count"]);
    }
    public function markSeen(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'id'      => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), [false]);
        }
        $notification = Notifications::where("id",  $request['id'])->first();
        $notification->update(
            [
                'seen' => true
            ]
        );
        return $this->sendresponse(200, 'notification seen sucessfully', [], [true]);
    }
    public function store(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'name'      => 'required',
            'description' => 'required',
            'to_user'    => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }
        $notification =   Notifications::create([
            'type' => 2,
            'name' => $request['name'],
            'description' => $request['description'],
            'to_user' => $request['to_user'],
            'from_user' => auth()->user()->id,
            'seen' => 0
        ]);
        $get = Notifications::where("id", "=", $notification->id)->first();

        broadcast(new AdminNotificationEvent($get));
        return $this->sendresponse(200, 'send notification successfuly', [], []);
    }
    public function sendall(Request $request)
    {
        $request = $request->json()->all();
        $users = User::select('id')->get();
        foreach ($users as $user) {
            Notifications::create([
                'type' => 3,
                'name' => $request['name'],
                'description' => $request['description'],
                'to_user' => $user->id,
                'from_user' => auth()->user()->id

            ]);
        }
        return $this->sendresponse(200, 'send notification to all users successfuly', [], []);
    }
    public function getSelectedFlightplan()
    {
        $get = Notifications::where('type', 5)->with(['user', 'order', 'order.toLocation', 'order.fromLocation', 'order.passengers', 'order.flightplans' => function ($q) {
            $q->where('selected', true);
        }])->orderByDesc('created_at');

        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);

        return $this->sendresponse(200, 'get notification successfuly', [], $res["model"]->append('flight_line'), null, $res["count"]);
    }
}