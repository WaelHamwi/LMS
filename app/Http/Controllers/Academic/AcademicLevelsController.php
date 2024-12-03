<?php

namespace App\Http\Controllers\Academic;


use App\Http\Requests\StoreAcademicLevels;
use App\Repositories\Academic\AcademicLevelRepositoryInterface;
use App\Models\AcademicLevel;
use App\Http\Controllers\Controller;

class AcademicLevelsController extends Controller
{
    protected $AcademicLevelRepository;

    public function __construct(AcademicLevelRepositoryInterface $AcademicLevelRepository)
    {
        $this->AcademicLevelRepository = $AcademicLevelRepository;
    }

    public function index()
    {

        return $this->AcademicLevelRepository->index();
    }

    public function create()
    {
        return $this->AcademicLevelRepository->create(new StoreAcademicLevels());
    }

    public function store(StoreAcademicLevels $request)
    {
        return $this->AcademicLevelRepository->store($request);
    }

    public function show(AcademicLevel $academicLevel)
    {
        return $this->AcademicLevelRepository->show($academicLevel);
    }

    public function edit(AcademicLevel $academicLevel)
    {
        return $this->AcademicLevelRepository->edit($academicLevel);
    }

    public function update(StoreAcademicLevels $request, AcademicLevel $academicLevel)
    {
        return $this->AcademicLevelRepository->update($request, $academicLevel);
    }

    public function destroy(AcademicLevel $academicLevel)
    {
        return $this->AcademicLevelRepository->destroy($academicLevel);
    }
    public function bulkDelete()
    {
        $ids = request()->input('ids', []);
        return $this->AcademicLevelRepository->bulkDelete($ids);
    }
}
