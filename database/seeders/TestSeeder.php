<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lab_tests')->insert([
            ['test_name'  =>  'Abdominal Ultrasound','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'Audiometry','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'Blood Examination','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'Blood Pressure','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'Body Measurement','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'Chest X-Ray','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'ECG','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'Opthalmologic Examination','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'Stool Examination','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'Upper Gatrointrestinal Examination','created_at'   =>  now(),'updated_at'   =>  now(),], 
            ['test_name'  =>  'Urine Analysis','created_at'   =>  now(),'updated_at'   =>  now(),],  
            ['test_name'  =>  'PCR Test','created_at'   =>  now(),'updated_at'   =>  now(),],   
        ]);
    }
}
