<?php

namespace App\Http\Controllers;

use DatePeriod;
use App\Models\Flightline;
use App\Models\Order;
use App\Models\ticket;
use App\Models\User;
use App\Traits\sendresponse;
use App\Traits\paging;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

        $userCount = DB::table('users')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw("DATE_FORMAT(created_At,'%Y-%m-%d') as monthNum, count(*) as userCount")
            ->orderBy('monthNum')
            ->groupBy('monthNum')
            ->get();

        $orderCount = DB::table('orders')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw("DATE_FORMAT(created_At,'%Y-%m-%d') as monthNum, count(*) as orderCount")
            ->orderBy('monthNum')
            ->groupBy('monthNum')
            ->get();
        $userCount = collect($userCount)->keyBy('monthNum')->map(function ($item) {
            $item->monthNum = \Carbon\Carbon::parse($item->monthNum);

            return $item;
        });
        $orderCount = collect($orderCount)->keyBy('monthNum')->map(function ($item) {
            $item->monthNum = \Carbon\Carbon::parse($item->monthNum);

            return $item;
        });

        $periods = new DatePeriod(Carbon::Now()->subDays(6), \Carbon\CarbonInterval::day(), Carbon::Now()->addDay());

        $userCount = array_map(function ($period) use ($userCount) {

            $month = $period->format('Y-m-d');

            return

                $userCount->has($month) ? $userCount->get($month)->userCount : 0;
        }, iterator_to_array($periods));

        $orderCount = array_map(function ($period) use ($orderCount) {

            $month = $period->format('Y-m-d');

            return
                $orderCount->has($month) ? $orderCount->get($month)->orderCount : 0;
        }, iterator_to_array($periods));
        return $this->sendresponse(200, 'get count to dashboard', [], [
            'orders' => $orders,
            'users' => $users,
            'tickets' => $tickets,
            'flighlines' => $flighlines,
            'userCount' => $userCount,
            'orderCount' => $orderCount,

        ]);
    }
}
