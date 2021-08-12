<?php

namespace App\Http\Controllers;

use App\Console\Commands\discountflight;
use App\Models\discount_flight;
use App\Models\Flightline;
use App\Traits\paging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\sendresponse;

class discountController extends Controller
{
    use sendresponse, paging;
    public function get()
    {
        $get = discount_flight::with("flightline", 'toLocation', 'fromLocation');
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get all discount  successfuly', [], $res["model"], null, $res["count"]);
    }
    public function store(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [

            'details'       => 'required',
            'flightline_id'  => 'required|exists:flightlines,id',
            'discount'       => 'required|numeric',
            'miximum_number' => 'required|numeric',
            'current_user'   => 'required',
            'minimum_number' => 'required|numeric',
            'expair'         => 'required',
            'fromdate'       => 'required|date',
            'returndate'     => 'required|date',
            // type => one way or two way
            'type'          => 'required',
            'from'           => 'required',
            'to'             => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }
        $addDiscount = discount_flight::create($request);
        $get_discount = discount_flight::with('flightline', "fromLocation", "toLocation")->find($addDiscount->id);
        return $this->sendresponse(200, 'insert successfully discount', [], $get_discount);
    }
    public function delete(Request $request)
    {
        $request = $request->json()->all();
        try {
            $delete = discount_flight::find($request['id'])->delete();

            return $this->sendresponse(200, 'Delete successfully', [], $delete);
        } catch (\Throwable $th) {
            return $this->sendresponse(401, 'error delete', [], []);
        }
    }
    public function update(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'flightline_id'  => 'exists:flightlines,id',
            'discount'       => 'numeric',
            'miximum_number' => 'numeric',
            'minimum_number' => 'numeric',
            'fromdate'       => 'date',
            'returndate'     => 'date',
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }
        discount_flight::find($request['id'])->update($request);
        $updateDiscount = discount_flight::with("flightline", "fromLocation", "toLocation")->find($request['id']);
        return $this->sendresponse(200, 'update successfully discountFlight', [], $updateDiscount);
    }

    public function getsoft()
    {
        $get = discount_flight::onlyTrashed();
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get discount_flight soft delete successfully', [], $res["model"], null, $res["count"]);
    }
}