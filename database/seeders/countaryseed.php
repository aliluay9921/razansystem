<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class countaryseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countaries')->insert([
            'id'                => Uuid::uuid4()->toString(),
            'code'              => 'BGW',
            'geo'               => 'WGB',
            'cityName'          => "baghdad",
            'longName'          => 'iraq',
            'NameArbic'         => 'العراق'
        ]);
        DB::table('countaries')->insert([
            'id'                => Uuid::uuid4()->toString(),
            'code'              => 'EGP',
            'geo'               => 'Cairo',
            'cityName'          => "Cairo",
            'longName'          => 'EGYPT',
            'NameArbic'         => 'مصر'
        ]);
        DB::table('countaries')->insert([
            'id'                => Uuid::uuid4()->toString(),
            'code'              => 'USA',
            'geo'               => 'USA',
            'cityName'          => "washnton",
            'longName'          => 'Amirca',
            'NameArbic'         => 'امريكا'
        ]);
    }
}
