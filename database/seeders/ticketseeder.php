<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ticketseeder extends Seeder
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
        DB::table('tickets')->insert([
            'id' => Uuid::uuid4()->toString(),
            'order_id' => $order->id ,
            'ticket_id' => '11',
            'flightline_id'=> $flight->id,

        ]);
        DB::table('tickets')->insert([
            'id' => Uuid::uuid4()->toString(),
            'order_id' => $order->id ,
            'ticket_id' => '22',
            'flightline_id'=> $flight->id,

        ]);
        DB::table('tickets')->insert([
            'id' => Uuid::uuid4()->toString(),
            'order_id' => $order->id ,
            'ticket_id' => '33',
            'flightline_id'=> $flight->id,

        ]);

    }
}
}
}
