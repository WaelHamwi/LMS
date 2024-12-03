<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\AcademicLevel;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\StudentParent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $academicLevelId = AcademicLevel::first()->id ?? null;
        $classroomId = Classroom::first()->id ?? null;
        $sectionId = Section::first()->id ?? null;
        $parentId = StudentParent::first()->id ?? null;

        if (is_null($academicLevelId) || is_null($classroomId) || is_null($sectionId) || is_null($parentId)) {
            $this->command->warn('Required related data missing: make sure to seed AcademicLevel, Classroom, Section, and StudentParent tables first.');
            return;
        }

        
        $students = [
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'gender' => 'male',
                'blood' => 'O+',
                'nationality' => 'American',
                'date_of_birth' => '2005-09-15',
                'academic_level_id' => $academicLevelId,
                'classroom_id' => $classroomId,
                'section_id' => $sectionId,
                'parent_id' => $parentId,
                'academic_year' => '2024',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'gender' => 'female',
                'blood' => 'A+',
                'nationality' => 'Canadian',
                'date_of_birth' => '2006-03-22',
                'academic_level_id' => $academicLevelId,
                'classroom_id' => $classroomId,
                'section_id' => $sectionId,
                'parent_id' => $parentId,
                'academic_year' => '2024',
                'password' => Hash::make('password123'),
            ]
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }
    }
}
