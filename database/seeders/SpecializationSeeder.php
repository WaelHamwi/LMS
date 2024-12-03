<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;
class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations = [
            ['name' => 'Mathematics'],
            ['name' => 'Science'],
            ['name' => 'Literature'],
            ['name' => 'History'],
            ['name' => 'Computer Science'],
        ];

        foreach ($specializations as $specialization) {
            Specialization::create($specialization);
        }
    }
}
