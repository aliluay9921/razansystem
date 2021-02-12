<?php

namespace App\Http\Controllers;

use App\Models\Flightline;
use Illuminate\Http\Request;
use App\Traits\sendresponse;
use App\Traits\helper;
use App\Traits\paging;
use Illuminate\Support\Facades\Validator;

class flightlineController extends Controller
{
    use sendresponse, Helper, paging;

    public function Get()
    {

        $get = Flightline::select('id', 'name', 'image', 'active', 'created_at')->where('active', 1);
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($get,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'All flightline', [], $res["model"], null, $res["count"]);
    }
    public function store(Request $request)
    {
        $request = $request->json()->all();
        //   راح يحول الركوست الى array
        // $request['image'] واتعامل ويا على انه مصفوفة
        $validator = Validator::make($request, [
            'name' => 'unique:flightlines|regex:/(^[A-Z a-z\x{0621}-\x{064A}]+$)+/u',
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }
        $request['image'] = $this->uploadPicture($request['image'], '/image/');

        $create = Flightline::create($request);
        return $this->sendresponse(200, 'insert successfully flightline', [], $create);
    }
    public function update(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'id'   => 'required',
            'name' => 'regex:/(^[A-Z a-z\x{0621}-\x{064A}]+$)+/u',
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }

        if (array_key_exists('new_image', $request)) {
            $request['image'] = $this->uploadPicture($request['new_image'], '/image/');
        } elseif (!array_key_exists('image', $request)) {
            $request['image'] = 'null';
        } elseif (array_key_exists('image', $request)) {
            $request['image'] =  $request['image'];
        }
        $update = Flightline::find($request['id'])->update([
            'name' => $request['name'],
            'image' => $request['image']
        ]);
        $get = Flightline::find($request['id']);
        return $this->sendresponse(200, 'update successfully flightline', [], $get);
    }
    public function delete(Request $request)
    {
        $request = $request->json()->all();
        $flightline = Flightline::find($request['id']);
        try {
            $flightline->active = !$flightline->active;
            $flightline->save();
            return $this->sendresponse(200, 'delete successfully', [], $flightline);
        } catch (\Throwable $th) {

            return $this->sendresponse(200, 'delete not successfully', [], $flightline);
        }
    }
}