<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name'          =>  'Admin',
                'email'         =>  'admin@gmail.com',
                'password'      =>  bcrypt('password'),
                'is_super_admin'=>  '1',
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ]
        ]);
    }
}
