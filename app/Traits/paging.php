<?php

namespace App\Traits;

trait paging
{


    public function paging($model, $skip = 0, $limit = 10)
    {

        $count = $model->count();
        $model = $model->skip($skip)->take($limit)->get();
        $count = ceil($count / $limit);
        return ["model" => $model, "count" => $count];
    }
}
