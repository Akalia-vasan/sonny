<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialities')->insert([
            [
                'sp_code'     =>  'SP0001',
                'sp_name'     =>  'Urology',
                'sp_image'    =>  'specialities/specialities-01.png',
                'created_at'  =>  now(),
                'updated_at'  =>  now(),
            ],
            [
                'sp_code'     =>  'SP0002',
                'sp_name'     =>  'Neurology',
                'sp_image'    =>  'specialities/specialities-02.png',
                'created_at'  =>  now(),
                'updated_at'  =>  now(),
            ],
            [
                'sp_code'     =>  'SP0003',
                'sp_name'     =>  'Orthopedic',
                'sp_image'    =>  'specialities/specialities-03.png',
                'created_at'  =>  now(),
                'updated_at'  =>  now(),
            ],
            [
                'sp_code'     =>  'SP0004',
                'sp_name'     =>  'Cardiologist',
                'sp_image'    =>  'specialities/specialities-04.png',
                'created_at'  =>  now(),
                'updated_at'  =>  now(),
            ],
            [
                'sp_code'     =>  'SP0005',
                'sp_name'     =>  'Dentist',
                'sp_image'    =>  'specialities/specialities-05.png',
                'created_at'  =>  now(),
                'updated_at'  =>  now(),
            ],
        ]);
    }
}
