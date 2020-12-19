<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\Order;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\sendresponse;
use App\Traits\Helper;
use App\Traits\paging;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
  use sendresponse, Helper, paging;
  public function get(Request $request)
  {
    $Orders = Order::with(['passengers' => function ($q) {
      $q->where('deleted_at', null);
    }]);

    if (isset($_GET['id'])) {
      $Orders->where('id', $_GET['id']);
    }
    if (isset($_GET['from'])) {
      $Orders->where('from', $_GET['from']);
    }
    if (isset($_GET['to'])) {
      $Orders->where('to', $_GET['to']);
    }
    if (isset($_GET['fromdate'])) {
      $Orders->where('fromdate', $_GET['fromdate']);
    }
    if (isset($_GET['returndate'])) {
      $Orders->where('returndate', $_GET['returndate']);
    }
    // ميصير نسوي get  اكثر من مرة بالفاكشن 
    // فلازم نسوي مرة وحدة لكلهن
    if (!isset($_GET['skip']))
      $_GET['skip'] = 0;
    if (!isset($_GET['limit']))
      $_GET['limit'] = 10;
    $res = $this->paging($Orders,  $_GET['skip'],  $_GET['limit']);
    return $this->sendresponse(200, 'All Orders', [], $res["model"], null, $res["count"]);
  }

  public function store(Request $request)
  {
    $request = $request->json()->all();

    $validator = Validator::make($request, [
      'from' => 'required',
      'to' => 'required',
      'cabin' => 'required',
      'fromdate' => 'required|date|after_or_equal:today',
      'returndate' => 'required|date|after:fromdate',
      'passengers.*.name' => 'required|alpha',
      'passengers.*.passport_No' => 'required'
    ]);
    // ['passengers.*.passport_No'=>'required' ]  لان عدنة بل ركوست ارري بداخل ركوست ف لازم نسوي هل طريقة 


    if ($validator->fails()) {
      return $this->sendresponse(401, 'error validation', $validator->errors(), []);
    }



    $order = Order::create([
      'to' => $request['to'],
      'from' => $request['from'],
      'cabin' => $request['cabin'],
      'fromdate' => $request['fromdate'],
      'returndate' => $request['returndate'],
      'user_id' => auth()->user()->id
    ]);
    $employee = User::select('id', 'status')->where('status', 1)->first();
    Notifications::create([
      'type' => 0,
      'name' => 'انشاء طلب بواسطة مستخم ',
      'description' => 'تم انشاء طلب حجز ',
      'order_id' => $order->id,
      'to_user' => $employee->id,
      'from_user' => auth()->user()->id,
      'seen' => 0
    ]);
    $passengers = $request['passengers'];

    // in the request get array called passengers 

    foreach ($passengers as $passenger) {

      $passenger['picture_passport'] = $this->uploadPicture($passenger['picture_passport'], '/image/');
      $passenger['order_id'] = $order->id;
      $createpassnger = Passenger::create($passenger);
    }
    $order = Order::where('id', $order->id)->with('passengers');
    return $this->sendresponse(200, 'insert successfuly Orders', [], $order->get());
  }

  public function update(Request $request)
  {

    $request = $request->json()->all();
    $validator = Validator::make($request, [
      'id'   => 'required',
      'from' => 'required',
      'to' => 'required',
      'cabin' => 'required',
      'fromdate' => 'required|date',
      'returndate' => 'required|date'
    ]);
    if ($validator->fails()) {
      return $this->sendresponse(401, 'error validation', $validator->errors(), []);
    }
    $update = Order::find($request['id'])->update($request);
    $get = Order::find($request['id']);
    return $this->sendresponse(200, 'update successfully flightline', [], $get);
  }


  public function delete(Request $request)
  {
    $request = $request->json()->all();
    $order = Order::find($request['id']);
    try {
      $order->active = !$order->active;
      $order->save();
      return $this->sendresponse(200, 'delete successfully', [], $order);
    } catch (\Throwable $th) {

      return $this->sendresponse(200, 'delete not successfully', [], $order);
    }
  }
}