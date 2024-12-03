<?php

namespace App\Http\Controllers\Student;

use App\Repositories\Student\StudentRepositoryInterface;
use App\Http\Requests\StoreStudents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Log;  
class StudentsController extends Controller
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function index(Request $request)
    {
        return $this->studentRepository->index($request);
    }

    public function store(StoreStudents $request)
    {
        return $this->studentRepository->store($request);
    }

    public function show($id)
    {
        return $this->studentRepository->show($id);
    }

    public function edit($id)
    {
        return $this->studentRepository->edit($id);
    }

    public function update(StoreStudents $request, Student $student)
    {
        return $this->studentRepository->update($request, $student);
    }

    public function destroy(Student $student)
    {
        return $this->studentRepository->destroy($student);
    }

    public function bulkDelete(Request $request)
    {
        return $this->studentRepository->bulkDelete($request->ids);
    }
    public function getStudentsBySection(Request $request)
    {
        $sectionId = $request->input('section_id');
        Log::info('Received section_id: ' . $sectionId);
        if ($sectionId) {
            return $this->studentRepository->getStudentsBySection($sectionId);
        }
    }
    public function getStudentBalance($studentId){
        return $this->studentRepository->getStudentBalance($studentId);
    }
}
