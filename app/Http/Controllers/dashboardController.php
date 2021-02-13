<?php

namespace App\Http\Controllers;

use App\Models\Flightline;
use App\Models\Order;
use App\Models\ticket;
use App\Models\User;
use App\Traits\sendresponse;
use App\Traits\paging;


use Illuminate\Http\Request;

class dashboardController extends Controller
{
    use sendresponse, paging;
    public function get()
    {
        $orders = Order::count();
        $users = User::count();
        $tickets = ticket::count();
        $flighlines = Flightline::count();
        return $this->sendresponse(200, 'get count to dashboard', [], [
            'orders' => $orders,
            'users' => $users,
            'tickets' => $tickets,
            'flighlines' => $flighlines
        ]);
    }
}