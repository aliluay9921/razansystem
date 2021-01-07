<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class posationseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countaries = DB::table('countaries')->get();

        foreach ($countaries as $countary) {
            DB::table('posation_avillables')->insert([
                'id'                => Uuid::uuid4()->toString(),
                'countary_id'          => $countary->id,
            ]);
            DB::table('posation_avillables')->insert([
                'id'                => Uuid::uuid4()->toString(),
                'countary_id'          => $countary->id,
            ]);
            DB::table('posation_avillables')->insert([
                'id'                => Uuid::uuid4()->toString(),
                'countary_id'          => $countary->id,
            ]);
            DB::table('posation_avillables')->insert([
                'id'                => Uuid::uuid4()->toString(),
                'countary_id'          => $countary->id,
            ]);
        }
    }
}
