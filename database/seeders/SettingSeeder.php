<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'key'    =>  'name',
                'value'  =>  'SugoiMed',
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'logo',
                'value'  =>  null,
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'copyright',
                'value'  =>  'Copyright SugoiMed © 2021',
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'app_address',
                'value'  =>  'Noida',
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'app_email',
                'value'  =>  'SugoiMed@gmail.com',
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'app_mobile',
                'value'  =>  '9876543210',
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'app_version',
                'value'  =>  '1.0 beta',
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
        ]);
    }
}
