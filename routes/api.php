<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


route::post('registerguest', [\App\Http\Controllers\AuthCountroller::class, 'registerguest']);
route::middleware('auth:api')->group(function () {
    route::post('register', [\App\Http\Controllers\AuthCountroller::class, 'register'])->middleware('guest');
    route::post('login', [\App\Http\Controllers\AuthCountroller::class, 'login']);

    route::get('alluser', [\App\Http\Controllers\UserController::class, 'alluser'])->middleware('admin');
    route::get('user', [\App\Http\Controllers\UserController::class, 'currentuser']);
    route::put('user', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('user', [\App\Http\Controllers\UserController::class, 'delete']);

    route::get('flightline', [\App\Http\Controllers\flightlineController::class, 'Get'])->middleware('admin');
    route::post('flightline', [\App\Http\Controllers\flightlineController::class, 'store'])->middleware('admin');
    route::put('flightline', [\App\Http\Controllers\flightlineController::class, 'update'])->middleware('admin');
    route::delete('flightline', [\App\Http\Controllers\flightlineController::class, 'delete'])->middleware('admin');


    route::get('order', [\App\Http\Controllers\OrderController::class, 'get'])->middleware('admin');
    route::post('order', [\App\Http\Controllers\OrderController::class, 'store']);
    route::put('order', [\App\Http\Controllers\OrderController::class, 'update'])->middleware('admin');
    route::delete('order', [\App\Http\Controllers\OrderController::class, 'delete'])->middleware('admin');

    route::get('passengers', [\App\Http\Controllers\passengersController::class, 'get']);
    route::get('passengers_soft', [\App\Http\Controllers\passengersController::class, 'getsoft']);
    route::post('passengers', [\App\Http\Controllers\passengersController::class, 'restore']);
    route::put('passengers', [\App\Http\Controllers\passengersController::class, 'update']);
    route::delete('passengers', [\App\Http\Controllers\passengersController::class, 'delete']);


    route::get('allflightplan', [\App\Http\Controllers\flightplanController::class, 'get']);
    route::get('flightplan', [\App\Http\Controllers\flightplanController::class, 'getselected'])->middleware('admin');
    route::put('flightplan', [\App\Http\Controllers\flightplanController::class, 'selected'])->middleware('admin');
    route::post('flightplan', [\App\Http\Controllers\flightplanController::class, 'store'])->middleware('admin');

    route::post('notifications', [\App\Http\Controllers\notificationController::class, 'store'])->middleware('admin');
    route::get('notifications', [\App\Http\Controllers\notificationController::class, 'get']);

    route::get('notifications', [\App\Http\Controllers\notificationController::class, 'get']);
    route::post('notificationsbrodcast', [\App\Http\Controllers\notificationController::class, 'sendall'])->middleware('admin');

    route::get('countary', [\App\Http\Controllers\CountaryController::class, 'get']);
    route::post('countary', [\App\Http\Controllers\CountaryController::class, 'store'])->middleware('throttle:1500,1');

    route::get('ticketall', [\App\Http\Controllers\TicketController::class, 'getall']);
    route::get('ticket', [\App\Http\Controllers\TicketController::class, 'get']);
    route::post('ticket', [\App\Http\Controllers\TicketController::class, 'store']);
});