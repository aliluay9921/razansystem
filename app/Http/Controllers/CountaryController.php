<?php

namespace App\Http\Controllers;

use App\Models\countary;
use App\Traits\paging;
use App\Traits\sendresponse;
use Illuminate\Http\Request;

class CountaryController extends Controller
{
    use sendresponse, paging;
    public function get(Request $request)
    {
        $get = countary::select('id', 'code', 'geo', 'NameArbic', 'cityName', 'longName', 'created_at', 'updated_at');
        if (!$request->has("skip"))
            $request->skip = 0;
        if (!$request->has("limit"))
            $request->limit = 10;
        $res = $this->paging($get, $request->skip, $request->limit);
        return $this->sendresponse(200, 'get all countary successfuly', [], $res["model"], null, $res["count"]);
    }

    public function store(Request $request)
    {
        $request = $request->json()->all();
        $countary = countary::create($request);
        return $this->sendresponse(200, 'add country successfully', [], $countary);
    }
    public function update(Request $request)
    {
        $request = $request->json()->all();
        $countary = countary::find($request['id'])->update($request);
        return $this->sendresponse(200, 'update country successfully', [], $countary);
    }
    public function delete(Request $request)
    {
        $request = $request->json()->all();
        $countary = countary::find($request['id'])->delete();

        return $this->sendresponse(200, 'delete successfully', [], $countary);
    }
}