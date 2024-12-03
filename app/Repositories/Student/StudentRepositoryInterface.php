<?php

namespace App\Repositories\Student;

use App\Http\Requests\StoreStudents;
use App\Models\Student;
use Illuminate\Http\Request;

interface StudentRepositoryInterface
{
    public function index(Request $request);
    public function create(StoreStudents $request);
    public function store(StoreStudents $request);
    public function show($id);
    public function edit(Student $student);
    public function update(StoreStudents $request, Student $student);
    public function destroy(Student $student);
    public function bulkDelete(array $ids);
    public function getStudentsBySection($sectionId);
    public function getStudentBalance($studentId);
}
