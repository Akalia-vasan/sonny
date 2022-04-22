<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // SettingSeeder::class,
            // AreaSeeder::class,
            // TestSeeder::class,
            // BeautyServiceSeeder::class,
            // CountrySeeder::class,
            // StateSeeder::class,
            // CitySeeder::class,
            // AppContentSeeder::class,
            // SpecialitySeeder::class,
            // AdminSeeder::class,
            // UserSeeder::class,
            PermissionTableSeeder::class,
        ]);
    }
}
