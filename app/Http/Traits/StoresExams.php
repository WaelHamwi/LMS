<?php
namespace App\Http\Traits;

trait StoresExams
{
    /**
     * Generic method to store exams.
     *
     * @param array $validatedData Validated request data.
     * @param string $modelClass Model class to store the exams.
     * @return void
     */
    public function storeExams(array $validatedData, string $modelClass): void
    {
       
        foreach ($validatedData['subject_id'] as $index => $subject_id) {
            $modelClass::create([
                'name' => $validatedData['name'][$index],
                'subject_id' => $subject_id,
                'academic_level_id' => $validatedData['academic_level_id'][$index],
                'classroom_id' => $validatedData['classroom_id'][$index],
                'section_id' => $validatedData['section_id'][$index],
                'teacher_id' => $validatedData['teacher_id'][$index],
            ]);
        }
    }
}
