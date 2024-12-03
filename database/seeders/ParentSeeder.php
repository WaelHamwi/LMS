<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentParent;
use Illuminate\Support\Facades\DB;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentParent::create([
            'email' => 'john1@example.com',
            'password' => bcrypt('password'),
            'father_name' => 'John Sr.',
            'father_national_id' => '123456789',
            'father_passport_id' => 'A1234567',
            'father_phone' => '123-456-7890',
            'father_job' => 'Engineer',
            'father_nationality_id' => 1,
            'father_blood_id' => 1,
            'father_religion_id' => 1,
            'mother_name' => 'Jane Doe',
            'mother_national_id' => '987654321',
            'mother_passport_id' => 'B7654321',
            'mother_phone' => '987-654-3210',
            'mother_job' => 'Teacher',
            'mother_nationality_id' => 2,
            'mother_blood_id' => 2,
            'mother_religion_id' => 2,
        ]);
    }
}
