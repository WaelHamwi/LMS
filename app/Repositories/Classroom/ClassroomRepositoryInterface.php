<?php

namespace App\Repositories\Classroom;

use App\Http\Requests\StoreClassrooms;
use App\Models\Classroom;
use Illuminate\Http\Request;
interface ClassroomRepositoryInterface
{
    public function index();  
    public function create(StoreClassrooms $request);
    public function store(StoreClassrooms $request);
    public function show(Classroom $classroom);
    public function edit(Classroom $classroom);
    public function update(StoreClassrooms $request, Classroom $classroom);
    public function destroy(Classroom $classroom);
    public function bulkDelete(array $ids);
    public function getClassroomsByAcademicLevel(Request $request);
}
