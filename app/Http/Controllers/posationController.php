<?php

namespace App\Http\Controllers;

use App\Traits\sendresponse;
use Illuminate\Http\Request;
use App\Models\posation_avillable;
use App\Traits\Helper;
use App\Traits\paging;
use Illuminate\Support\Facades\Validator;


class posationController extends Controller
{
    use sendresponse, Helper, paging;

    public function get()
    {
        $get = posation_avillable::select('id', 'countary_id', 'image')->with(["countary"]);
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get posation_avillable  successfully', [], $res["model"], null, $res["count"]);
    }

    public function store(Request $request)
    {

        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'countary_id'       => 'required|exists:countaries,id',
            'new_image'         => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }

        if (array_key_exists('new_image', $request)) {
            $request['image'] = $this->uploadPicture($request['new_image'], '/image/');
        } elseif (!array_key_exists('image', $request)) {
            $request['image'] = null;
        } elseif (array_key_exists('image', $request)) {
            $request['image'] =  $request['image'];
        }

        posation_avillable::create($request);
        return $this->sendresponse(200, 'insert successfully posation_avillable', [], []);
    }

    public function delete(Request $request)
    {
        $request = $request->json()->all();
        try {
            $delete = posation_avillable::find($request['id'])->delete();

            return $this->sendresponse(200, 'Delete successfully', [], $delete);
        } catch (\Throwable $th) {
            return $this->sendresponse(401, 'error delete', [], []);
        }
    }
}
