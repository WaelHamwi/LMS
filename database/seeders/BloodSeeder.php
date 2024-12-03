<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use App\Models\Blood;

class BloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $bloodTypes = [
            ['type' => 'A+'],
            ['type' => 'A-'],
            ['type' => 'B+'],
            ['type' => 'B-'],
            ['type' => 'AB+'],
            ['type' => 'AB-'],
            ['type' => 'O+'],
            ['type' => 'O-'],
        ];

        Blood::insert($bloodTypes);
    }
}
