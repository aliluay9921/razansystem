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
            'Name' => ' الخطوط الجوية العراقية ',
            'image' => '\image\download.jfif',
        ]);
        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => ' الخطوط الجوية التركية ',
            'image' => '\image\download(2).jfif',
        ]);
        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => ' الخطوط الجوية القطرية ',
            'image' => '\image\download(1).jfif',
        ]);

        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => ' الخطوط الجوية الملكية الاردنية ',
            'image' => '\image\download(4).jfif',
        ]);
        DB::table('Flightlines')->insert([
            'id' => Uuid::uuid4()->toString(),
            'Name' => ' الخطوط الجوية الاماراتية ',
            'image' => '\image\download(3).jfif',
        ]);

    }
}
