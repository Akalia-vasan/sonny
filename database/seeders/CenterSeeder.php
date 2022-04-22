<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('centers')->insert([
            [
                'center_name'  =>  'Noida',
                'lattitude'    =>  '28.535517',
                'longitude'    =>  '77.391029',
                'active'       =>  '1',
                'created_at'   =>  now(),
                'updated_at'   =>  now(),
            ],
            [
                'center_name'  =>  'Delhi',
                'lattitude'    =>  '28.704060',
                'longitude'    =>  '77.102493',
                'active'       =>  '1',
                'created_at'   =>  now(),
                'updated_at'   =>  now(),
            ]
        ]);
    }
}
