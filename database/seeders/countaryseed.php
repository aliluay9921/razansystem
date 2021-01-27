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
            'cityName'          => "Baghdad",
            'longName'          => 'Iraq',
            'NameArbic'         => 'العراق'
        ]);
        DB::table('countaries')->insert([
            'id'                => Uuid::uuid4()->toString(),
            'code'              => 'EGP',
            'geo'               => 'Cairo',
            'cityName'          => "Cairo",
            'longName'          => 'Egypt',
            'NameArbic'         => 'مصر'
        ]);
        DB::table('countaries')->insert([
            'id'                => Uuid::uuid4()->toString(),
            'code'              => 'USA',
            'geo'               => 'USA',
            'cityName'          => "NEW YORK",
            'longName'          => 'United States',
            'NameArbic'         => 'امريكا'
        ]);
    }
}
