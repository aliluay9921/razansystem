<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\Helper;
use App\Traits\paging;
use App\Traits\sendresponse;
use Laravel\Passport\Passport;

class passengersController extends Controller
{

    use sendresponse, Helper, paging;
    public function update(Request $request)
    {

        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'id'   => 'required',
            'name' => 'required|regex:/(^[A-Z a-z\x{0621}-\x{064A}]+$)+/u',
            'type' => 'required',
            'gender' => 'required',
            'passport_No' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }

        if (array_key_exists('new_image', $request)) {
            $request['picture_passport'] = $this->uploadPicture($request['new_image'], '/image/');
        } elseif (!array_key_exists('picture_passport', $request)) {
            $request['picture_passport'] = null;
        } elseif (array_key_exists('picture_passport', $request)) {
            $request['picture_passport'] =  $request['picture_passport'];
        }

        $update = Passenger::find($request['id'])->update($request);
        $get = Passenger::find($request['id']);
        return $this->sendresponse(200, 'Update successfully', [], $get);
    }

    public function delete(Request $request)
    {
        $request = $request->json()->all();
        try {
            $delete = Passenger::find($request['id'])->delete();

            return $this->sendresponse(200, 'Delete successfully', [], $delete);
        } catch (\Throwable $th) {
            return $this->sendresponse(401, 'error delete', [], []);
        }
    }

    public function getsoft()
    {
        $get = Passenger::onlyTrashed();
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get passengers soft delete successfully', [], $res["model"], null, $res["count"]);
    }

    public function restore(Request $request)
    {
        $request = $request->json()->all();
        $findsoft = Passenger::withTrashed()->find($request['id'])->restore();

        return $this->sendresponse(200, 'restore  soft delete successfully', [], $findsoft);
    }
}