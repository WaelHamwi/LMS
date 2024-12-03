<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate all relevant tables
        DB::table('users')->truncate();
        DB::table('teachers')->truncate();
        DB::table('students')->truncate();
        DB::table('attachments')->truncate();
        DB::table('student_parents')->truncate();
        DB::table('nationalities')->truncate();
        DB::table('bloods')->truncate();
        DB::table('religions')->truncate();
        DB::table('genders')->truncate();
        DB::table('specializations')->truncate();
        DB::table('settings')->truncate();




        $this->call([

            // Child tables
            UsersTableSeeder::class,

            // Additional tables
            GenderSeeder::class,
            SpecializationSeeder::class,

            // Parent tables relations
            NationalitySeeder::class,
            BloodSeeder::class,
            ReligionSeeder::class,

            //parent table
            ParentSeeder::class,

            //teacher table
            TeacherSeeder::class,

            //settings table
            SettingsSeeder::class
        ]);
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
