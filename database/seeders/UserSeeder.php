<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'  =>  'Test',
                'lname'  =>  '',
                'email'    =>  'test@gmail.com',
                'mobile'    =>  '9876543210',
                'email_verified_at'=>now(),
                'mobile_verified_at'=>now(),
                'password'=> Hash::make('password'),
                'active'       =>  '1',
                'created_at'   =>  now(),
                'updated_at'   =>  now(),
            ]
        ]);
    }
}
