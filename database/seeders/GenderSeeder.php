<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Genders')->truncate();
        $genders = [
            ['name' => 'Male'],
            ['name' => 'Female'],
        ];

        foreach ($genders as $gender) {
            Gender::create($gender);
        }
    }
}
