<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\StoreTeachers;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Http\Controllers\Controller;

class TeachersController extends Controller
{
    protected $teacherRepository;

    public function __construct(TeacherRepositoryInterface $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function index(Request $request)
    {
        return $this->teacherRepository->index($request);
    }

    public function create(StoreTeachers $request)
    {
        return $this->teacherRepository->create($request);
    }

    public function store(StoreTeachers $request)
    {
        return $this->teacherRepository->store($request);
    }

    public function show(Teacher $teacher)
    {
        return $this->teacherRepository->show($teacher);
    }

    public function edit(Teacher $teacher)
    {
        return $this->teacherRepository->edit($teacher);
    }

    public function update(StoreTeachers $request, Teacher $teacher)
    {
        return $this->teacherRepository->update($request, $teacher);
    }

    public function destroy(Teacher $teacher)
    {
        return $this->teacherRepository->destroy($teacher);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        return $this->teacherRepository->bulkDelete($ids);
    }
}
