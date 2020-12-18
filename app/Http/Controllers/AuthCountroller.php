<?php

namespace App\Http\Controllers;

use App\Models\firbasetokens;
use App\Models\User;
use App\Traits\sendresponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthCountroller extends Controller
{
    use sendresponse;
    public function register(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'FullName' => 'required',
            'UserName' => 'required|unique:users',
            'password' => 'required|min:6|max:20',
            'PhoneNumber' => 'required|min:10|max:14'
        ]);
        if ($validator->fails()) {

            return $this->sendresponse(401, 'error validation', $validator->errors(), []);
        }
        // if user guest 
        $user_id = auth()->user()->id;


        $user = User::find($user_id)->update([
            'FullName' => $request['FullName'],
            'UserName' => $request['UserName'],
            'password' => bcrypt($request['password']),
            'PhoneNumber' => $request['PhoneNumber'],
        ]);
        $user = User::find($user_id);
        return $this->sendresponse(200, 'register has been successfuly', [], $user, null);
    }

    public function login(Request $request)
    {
        $request = $request->json()->all();
        $user = Auth::user();
        $user->delete();
        if (Auth::check(['UserName' => $request['UserName'], 'password' => $request['password']])) {
            Auth::setUser(User::where('UserName', $request['UserName'])->first());
            firbasetokens::where('user_id', $user->id)->delete();
            $user = Auth::user();

            firbasetokens::create([
                'user_id' => $user->id,
                'token'   => $request['token']
            ]);
            $success['token'] = $user->createToken('myApp')->accessToken;
            return $this->sendresponse(200, 'login has been successfuly', [], $user, $success['token']);
        } else {
            return $this->sendresponse(401, 'Unauthorized', null, null, null);
        }
    }

    public function registerguest(Request $request)
    {
        $request = $request->json()->all();
        $validator = Validator::make($request, [
            'token' => 'required'
        ]);
        $user = User::create([
            'status' => 0,
            'active' => 1
        ]);
        $token = $user->createToken('myApp')->accessToken;


        firbasetokens::create([
            'user_id' => $user->id,
            'token'   => $request['token']
        ]);
        return $this->sendresponse(200, 'user geust created', null, [$user->id], $token);
    }
}