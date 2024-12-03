<?php

namespace App\Http\Controllers\Classroom;


use App\Http\Requests\StoreClassrooms;
use App\Repositories\Classroom\ClassroomRepositoryInterface;
use App\Models\Classroom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassroomsController extends Controller
{
    protected $ClassroomRepository;
    public function __construct(ClassroomRepositoryInterface $ClassroomRepository)
    {
        $this->ClassroomRepository = $ClassroomRepository;
    }

    public function index()
    {
        return $this->ClassroomRepository->index();
    }

    public function create()
    {
        return $this->ClassroomRepository->create(new StoreClassrooms());
    }

    public function store(StoreClassrooms $request)
    {

        return $this->ClassroomRepository->store($request);
    }

    public function show(Classroom $Classroom)
    {
        return $this->ClassroomRepository->show($Classroom);
    }

    public function edit(Classroom $Classroom)
    {
        return $this->ClassroomRepository->edit($Classroom);
    }

    public function update(StoreClassrooms $request, Classroom $Classroom)
    {
        return $this->ClassroomRepository->update($request, $Classroom);
    }

    public function destroy(Classroom $Classroom)
    {
        return $this->ClassroomRepository->destroy($Classroom);
    }
    public function bulkDelete()
    {

        $ids = request()->input('ids', []);
        return $this->ClassroomRepository->bulkDelete($ids);
    }
    public function getClassroomsByAcademicLevel(Request $request)
    {
        return $this->ClassroomRepository->getClassroomsByAcademicLevel($request);
    }
}
