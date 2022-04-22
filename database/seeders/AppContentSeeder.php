<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_contents')->insert([
            [
                'key'    =>  'privacy_policy',
                'heading'  =>  'Generate Privacy Policy',
                'content'  =>  "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'privacy_policy',
                'heading'  =>  'Policy Maker will help you',
                'content'  =>  "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'term_condition',
                'heading'  =>  'What are Term & Condition',
                'content'  =>  "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'term_condition',
                'heading'  =>  'Generate Term & Condition',
                'content'  =>  "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'disclaimer',
                'heading'  =>  'Waiver signing',
                'content'  =>  "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
            [
                'key'    =>  'disclaimer',
                'heading'  =>  'Lorem Ipsum is simply dummy text of the printing',
                'content'  =>  "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ],
        ]);
    }
}
