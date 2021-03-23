<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\sendresponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Traits\paging;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use sendresponse, paging;
    public function alluser()
    {
        $alluser = User::select('id', 'firstName', 'lastName', 'PhoneNumber', 'UserName', 'password', 'email_verified_at', 'remember_token', 'updated_at', 'created_at', 'status', 'active');
        if (isset($_GET['id'])) {
            $alluser->where('id', $_GET['id']);
        }
        if (isset($_GET['firstName'])) {
            $alluser->where('firstName', $_GET['firstName']);
        }
        if (isset($_GET['lastName'])) {
            $alluser->where('lastName', $_GET['lastName']);
        }
        if (isset($_GET['UserName'])) {
            $alluser->where('UserName', $_GET['UserName']);
        }
        if (isset($_GET['PhoneNumber'])) {
            $alluser->where('PhoneNumber', $_GET['PhoneNumber']);
        }
        if (isset($_GET['PhoneNumber'])) {
            $alluser->where('PhoneNumber', $_GET['PhoneNumber']);
        }

        if (isset($_GET['created_at'])) {
            $alluser->where('created_at', $_GET['created_at']);
        }
        if (!isset($_GET['skip']))
            $_GET['skip'] = 0;
        if (!isset($_GET['limit']))
            $_GET['limit'] = 10;
        $res = $this->paging($alluser,  $_GET['skip'],  $_GET['limit']);
        return $this->sendresponse(200, 'get all user', [], $res["model"], null, $res["count"]);
    }
    public function currentuser()
    {
        $currnet = auth()->user();
        return $this->sendresponse(200, 'get currnet user', [], $currnet);
    }
    public function update(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'fisrtName' => 'required|regex:/(^[A-Z a-z\x{0621}-\x{064A}]+$)+/u',
            'lastName' => 'required|regex:/(^[A-Z a-z\x{0621}-\x{064A}]+$)+/u',
            'UserName' => 'required|unique:users,UserName,' . auth()->user()->id,
            'password' => 'required|min:6|max:20',
            'PhoneNumber' => 'required|min:10|max:14'
        ]);
        if ($validator->fails()) {
            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }
        $update = User::find(auth()->user()->id)->Update([
            'fisrtName' => $request['fisrtName'],
            'lastName' => $request['lastName'],
            'UserName' => $request['UserName'],
            'password' => Hash::make($request['password']),
            'PhoneNumber' => $request['PhoneNumber'],

        ]);
        $user = User::find(auth()->user()->id);
        return $this->sendresponse(200, 'Update successfully', [], $user);
    }

    public function delete(Request $request)
    {
        $request = $request->json()->all();
        $user = User::find($request['id']);
        try {
            $user->active = !$user->active;
            $user->save();
            return $this->sendresponse(200, 'delete successfully', [], $user);
        } catch (\Throwable $th) {

            return $this->sendresponse(200, 'delete not successfully', [], $user);
        }
    }
}