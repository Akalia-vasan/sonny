<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeautyServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('beauty_services')->insert([
            ['service_name'  =>  'Breast Augmentation','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Cosmetic Dental','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Eyes Double Fold Surgery','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Face Lines','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Gynecological Formation','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Hyperhidrosis','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Laser Skin Toning','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Liposuction','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Medical Laser Hair Removal','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Rejuvenation Treatment','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Rhinoplasty','created_at'   =>  now(),'updated_at'   =>  now(),],
            ['service_name'  =>  'Tattoo Removal','created_at'   =>  now(),'updated_at'   =>  now(),],
            
        ]);
    }
}
