<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceiptProcessFeeStudentRequest;
use App\Repositories\Student\ProcessFeeStudentRepositoryInterface;

class ProcessFeeStudentController extends Controller
{
    protected $processFeeStudentRepository;

    public function __construct(ProcessFeeStudentRepositoryInterface $processFeeStudentRepository)
    {
        $this->processFeeStudentRepository = $processFeeStudentRepository;
    }

    public function index()
    {
        return $this->processFeeStudentRepository->all();
    }

    public function show($id)
    {
        return $this->processFeeStudentRepository->find($id);
    }

    public function store(StoreReceiptProcessFeeStudentRequest $request)
    {
        return $this->processFeeStudentRepository->create($request->validated());
    }

    public function update(StoreReceiptProcessFeeStudentRequest $request, $id)
    {
        return $this->processFeeStudentRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->processFeeStudentRepository->destroy($id);
    }
}
