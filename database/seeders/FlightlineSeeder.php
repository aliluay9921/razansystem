<?php

namespace Database\Seeders;

use App\Traits\Uuids;
use Ramsey\Uuid\Uuid;
use App\Models\Flightline;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlightlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => 'Iraqi Airlines',
            'image' => '/image/1607949921ht.jpeg',
        ]);
        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => 'Turkish Airlines',
            'image' => '/image/1607949921ht.jpeg',
        ]);
        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => 'Qatar Airlines',
            'image' => '/image/1607949921ht.jpeg',
        ]);

        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => 'Jordan Airlines',
            'image' => '/image/1607949921ht.jpeg',
        ]);
        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => 'Emirates Airlines',
            'image' => '/image/1607949921ht.jpeg',
        ]);
    }
}