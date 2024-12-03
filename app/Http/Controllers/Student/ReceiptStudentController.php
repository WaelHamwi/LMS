<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceiptProcessFeeStudentRequest;
use App\Repositories\Student\ReceiptStudentRepositoryInterface;

class ReceiptStudentController extends Controller
{
    protected $receiptStudentRepository;

    public function __construct(ReceiptStudentRepositoryInterface $receiptStudentRepository)
    {
        $this->receiptStudentRepository = $receiptStudentRepository;
    }

    public function index()
    {
        return $this->receiptStudentRepository->all();
    }

    public function show($id)
    {
        return $this->receiptStudentRepository->find($id);
    }

    public function store(StoreReceiptProcessFeeStudentRequest $request)
    {
        return $this->receiptStudentRepository->create($request->validated());
    }

    public function update(StoreReceiptProcessFeeStudentRequest $request, $id)
    {
        return $this->receiptStudentRepository->update($id, $request->validated());
    }
    public function destroy($id)
    {
        return $this->receiptStudentRepository->destroy($id);
    }
    public function bulkDelete()
    {
        $ids = request()->input('ids', []);
        return $this->receiptStudentRepository->bulkDelete($ids);
    }
}
