<?php

namespace App\Http\Controllers;

use App\Events\notifications as EventsNotifications;
use App\Events\NotificationsEvent;
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
        $get = Notifications::where('to_user', auth()->user()->id)->orderByDesc('created_at')->with('orders');
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get notification successfuly', [], $res["model"], null, $res["count"]);
    }

    public function store(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'name '      => 'required',
            'description' => 'required',
            'to_user'    => 'required',
            'from_user'  => 'required'
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
        $get = Notifications::find($notification->id);
        broadcast(new NotificationsEvent($get, auth()->user()));
        return $this->sendresponse(200, 'send notification successfuly', [], []);
    }
    public function sendall(Request $request)
    {
        $request = $request->json()->all();
        $users = User::select('id')->get();
        foreach ($users as $user) {
            Notifications::create([
                'type' => 0,
                'name' => $request['name'],
                'description' => $request['description'],
                'to_user' => $user['id'],
                'from_user' => auth()->user()->id

            ]);
        }
        return $this->sendresponse(200, 'send notification to all users successfuly', [], []);
    }
}