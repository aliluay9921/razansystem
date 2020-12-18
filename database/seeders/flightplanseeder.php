<?php

namespace Database\Seeders;

use App\Models\Flightline;
use App\Models\Order;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class flightplanseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = DB::table('orders')->get();
        $flights = DB::table('flightlines')->get();
        foreach($orders as $order ){
            foreach($flights as $flight ){
        DB::table('flightplans')->insert([
            'id' => Uuid::uuid4()->toString(),
            'order_id' => $order->id ,
            'price' => 33,
            'flight_id'=> $flight->id,
            'note'=>'hello',
            "selected"=>false
        ]);
   
    }
}
}
}

