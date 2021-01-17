<?php

namespace Database\Seeders;

use App\Models\Order;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class passengerseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     *
     */

    public function run()
    {
        $get = DB::table('orders')->get();
        foreach ($get as $orders) {
            DB::table('passengers')->insert([
                'id'                => Uuid::uuid4()->toString(),
                'name'              => 'ali luay ',
                'order_id'          => $orders->id,
                'type'              => 1,
                'birth_day'         => '2020/12/12',
                'gender'            => 1,
                'picture_passport'  => '\image\download(3).jfif',
                'passport_No'       => '1212121',

            ]);

            DB::table('passengers')->insert([
                'id'                => Uuid::uuid4()->toString(),
                'name'              => 'baqer ',
                'order_id'          => $orders->id,
                'type'              => 1,
                'gender'            => 1,
                'birth_day'         => '2020/12/12',
                'picture_passport'  => '\image\download(3).jfif',
                'passport_No'       => '1212121',

            ]);
            DB::table('passengers')->insert([
                'id'                => Uuid::uuid4()->toString(),
                'name'              => 'ibrahim ',
                'order_id'          => $orders->id,
                'type'              => 1,
                'gender'            => 1,
                'birth_day'         => '2020/12/12',
                'picture_passport'  => '/image/16079728434v.jpeg',
                'passport_No'       => '545454',

            ]);
            DB::table('passengers')->insert([
                'id'                => Uuid::uuid4()->toString(),
                'name'              => 'ali luay ',
                'order_id'          => $orders->id,
                'type'              => 1,
                'birth_day'         => '2020/12/12',
                'gender'            => 1,
                'picture_passport'  => '\image\download(3).jfif',
                'passport_No'       => '1212121',

            ]);
        }
    }
}