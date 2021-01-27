<?php

namespace App\Traits;

trait sendresponse
{


    public function sendresponse($code, $message, $error, $result = null, $token = null, $count = -1)
    {


        //  هنا حتى مترجع array of object of array
        if (!is_array($result) && !is_a($result, 'Illuminate\Database\Eloquent\Collection'))
            if ($result == null)
                $result = [];
            else
                $result = [$result];


        $response = [
            'code' => $code,
            'message' => $message,
            'errors' => $error,
            'result' => $result,
            'token' => $token,
            'count' => $count

        ];
        return response()->json($response);
    }
}
