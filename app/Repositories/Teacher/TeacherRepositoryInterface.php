<?php

namespace App\Repositories\Teacher;

use App\Http\Requests\StoreTeachers;
use App\Models\Teacher;
use Illuminate\Http\Request;
interface TeacherRepositoryInterface
{
    public function index(Request $request);
    public function create(StoreTeachers $request);
    public function store(StoreTeachers $request);
    public function show(Teacher $teacher);
    public function edit(Teacher $teacher);
    public function update(StoreTeachers $request, Teacher $teacher);
    public function destroy(Teacher $teacher);
    public function bulkDelete(array $ids);

}
