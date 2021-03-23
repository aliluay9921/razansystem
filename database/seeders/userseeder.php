<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'                => Uuid::uuid4()->toString(),
            'first_name'          => 'ali',
            'last_name'          => 'luay',
            'UserName'          => 'aliali2',
            'password'          => Hash::make('11111111'),
            'PhoneNumber'       => '077110101010',
            'status'            => 1,
            'active'            => 1

        ]);
        DB::table('users')->insert([
            'id'                => Uuid::uuid4()->toString(),
            'first_name'          => 'ibrahim',
            'last_name'          => 'ayad',
            'UserName'          => 'aliali1',
            'password'          => Hash::make('11111111'),
            'PhoneNumber'       => '077110101010',
            'status'            => 0,
            'active'            => 1

        ]);
        DB::table('users')->insert([
            'id'                => Uuid::uuid4()->toString(),
            'first_name'          => 'yousuf',
            'last_name'          => 'abdalstar',
            'UserName'          => 'aliali',
            'password'          => Hash::make('11111111'),
            'PhoneNumber'       => '077110101010',
            'status'            => 2,
            'active'            => 1

        ]);
    }
}