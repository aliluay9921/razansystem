<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\AdminNotificationEvent;
use Illuminate\Support\Facades\Broadcast;



route::post('registerguest', [\App\Http\Controllers\AuthCountroller::class, 'registerguest']);
route::post('loginadmin', [\App\Http\Controllers\AuthCountroller::class, 'loginadmin']);

route::middleware(['auth:api'])->group(function () {

    route::post('register', [\App\Http\Controllers\AuthCountroller::class, 'register'])->middleware('guest');
    route::post('login', [\App\Http\Controllers\AuthCountroller::class, 'login']);

    route::get('alluser', [\App\Http\Controllers\UserController::class, 'alluser'])->middleware('admin');
    route::get('user', [\App\Http\Controllers\UserController::class, 'currentuser']);
    route::put('user', [\App\Http\Controllers\UserController::class, 'update']);
    route::delete('user', [\App\Http\Controllers\UserController::class, 'delete'])->middleware('admin');

    route::get('flightline', [\App\Http\Controllers\flightlineController::class, 'Get']); //->middleware('admin');
    route::post('flightline', [\App\Http\Controllers\flightlineController::class, 'store'])->middleware('admin');
    route::put('flightline', [\App\Http\Controllers\flightlineController::class, 'update'])->middleware('admin');
    route::delete('flightline', [\App\Http\Controllers\flightlineController::class, 'delete'])->middleware('admin');

    route::get('orderadmin', [\App\Http\Controllers\OrderController::class, 'get']);
    route::get('order', [\App\Http\Controllers\OrderController::class, 'getuser']);
    route::get('orderPnr', [\App\Http\Controllers\OrderController::class, 'orderPnr']);
    route::post('order', [\App\Http\Controllers\OrderController::class, 'store']);
    route::post('savePNR', [\App\Http\Controllers\OrderController::class, 'savePNR'])->middleware('admin');
    route::put('order', [\App\Http\Controllers\OrderController::class, 'update']);
    route::delete('order', [\App\Http\Controllers\OrderController::class, 'delete'])->middleware('admin');


    route::get('passengers', [\App\Http\Controllers\passengersController::class, 'get'])->middleware('admin');
    route::get('passengers_soft', [\App\Http\Controllers\passengersController::class, 'getsoft'])->middleware('admin');
    route::post('passengers', [\App\Http\Controllers\passengersController::class, 'restore'])->middleware('admin');
    route::put('passengers', [\App\Http\Controllers\passengersController::class, 'update']);
    route::delete('passengers', [\App\Http\Controllers\passengersController::class, 'delete'])->middleware('admin');

    route::get('allflightplan', [\App\Http\Controllers\flightplanController::class, 'get']);
    route::get('flightplan', [\App\Http\Controllers\flightplanController::class, 'getselected'])->middleware('admin');
    route::put('flightplan', [\App\Http\Controllers\flightplanController::class, 'selected']);
    route::post('flightplan', [\App\Http\Controllers\flightplanController::class, 'store'])->middleware('admin');

    route::post('notifications', [\App\Http\Controllers\notificationController::class, 'store']);
    route::get('notifications', [\App\Http\Controllers\notificationController::class, 'get']);
    route::get('notificationsSelected', [\App\Http\Controllers\notificationController::class, 'getSelectedFlightplan'])->middleware('admin');
    route::get('notifications_admin_employee', [\App\Http\Controllers\notificationController::class, 'getBroadCast'])->middleware('admin');
    route::get('notifications_employee', [\App\Http\Controllers\notificationController::class, 'getemployee'])->middleware('admin');
    route::post('notificationsbrodcast', [\App\Http\Controllers\notificationController::class, 'sendall'])->middleware('admin');
    route::put('seen', [\App\Http\Controllers\notificationController::class, 'markSeen'])->middleware('admin');

    route::get('countary', [\App\Http\Controllers\CountaryController::class, 'get']);
    route::post('countary', [\App\Http\Controllers\CountaryController::class, 'store'])->middleware('throttle:1500,1');
    route::put('countary', [\App\Http\Controllers\CountaryController::class, 'update']);
    route::delete('countary', [\App\Http\Controllers\CountaryController::class, 'delete']);

    route::get('ticketall', [\App\Http\Controllers\TicketController::class, 'getAll'])->middleware('admin');
    route::get('getTicketPnr', [\App\Http\Controllers\TicketController::class, 'getTicketPnr'])->middleware('admin');
    route::get('ticket', [\App\Http\Controllers\TicketController::class, 'get']);
    route::post('ticket', [\App\Http\Controllers\TicketController::class, 'store']);
    route::get("get_ticket_by_pnr", [\App\Http\Controllers\TicketController::class, 'getTicketByPnr']);
    route::put('ticket', [\App\Http\Controllers\TicketController::class, 'Issue']);

    route::get('discount', [\App\Http\Controllers\discountController::class, 'get']);
    route::post('discount', [\App\Http\Controllers\discountController::class, 'store'])->middleware('admin');
    route::put('discount', [\App\Http\Controllers\discountController::class, 'update'])->middleware('admin');
    route::delete('discount', [\App\Http\Controllers\discountController::class, 'delete'])->middleware('admin');
    route::get('discount_soft', [\App\Http\Controllers\discountController::class, 'getsoft'])->middleware('admin');

    route::get('posation', [\App\Http\Controllers\posationController::class, 'get']);
    route::post('posation', [\App\Http\Controllers\posationController::class, 'store'])->middleware('admin');
    route::put('posation', [\App\Http\Controllers\posationController::class, 'update'])->middleware('admin');
    route::delete('posation', [\App\Http\Controllers\posationController::class, 'delete'])->middleware('admin');

    route::get('dashboardCount', [\App\Http\Controllers\dashboardController::class, 'get'])->middleware('admin');
});

Route::get('/fire', function () {
    broadcast(new AdminNotificationEvent('test'));
    return response()->json(["test"], 200);
});
Broadcast::routes(['middleware' => ['auth:api']]);
