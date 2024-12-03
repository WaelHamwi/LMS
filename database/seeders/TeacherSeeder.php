<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Specialization;
use App\Models\Gender;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $genders = Gender::all();
        $specializations = Specialization::all();

        $teachers = [
            [
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'email' => 'alice2@example.com',
                'password' => Hash::make('password'),
                'address' => '123 Elm Street',
                'gender_id' => $genders->where('name', 'Female')->first()->id,
                'specialization_id' => $specializations->where('name', 'Literature')->first()->id,
                'join_date' => now(),
            ],
            [
                'first_name' => 'Bob',
                'last_name' => 'Smith',
                'email' => 'bob2@example.com',
                'password' => Hash::make('password'),
                'address' => '456 Oak Avenue',
                'gender_id' => $genders->where('name', 'Male')->first()->id,
                'specialization_id' => $specializations->where('name', 'Mathematics')->first()->id,
                'join_date' => now(),
            ],

        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}
