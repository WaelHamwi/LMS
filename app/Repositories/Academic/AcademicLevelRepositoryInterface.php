<?php

namespace App\Repositories\Academic;

use App\Http\Requests\StoreAcademicLevels; 
use App\Models\AcademicLevel;

interface AcademicLevelRepositoryInterface
{
    public function index();
    public function create(StoreAcademicLevels $request);
    public function store(StoreAcademicLevels $request);
    public function show(AcademicLevel $academicLevel);
    public function edit(AcademicLevel $academicLevel);
    public function update(StoreAcademicLevels $request, AcademicLevel $academicLevel);
    public function destroy(AcademicLevel $academicLevel);
    public function bulkDelete(array $ids); 
}
