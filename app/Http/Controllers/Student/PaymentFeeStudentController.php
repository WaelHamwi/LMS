<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceiptProcessFeeStudentRequest;
use App\Repositories\Student\PaymentFeeStudentRepositoryInterface;

class PaymentFeeStudentController extends Controller
{
    protected $PaymentFeeStudentRepository;

    public function __construct(PaymentFeeStudentRepositoryInterface $PaymentFeeStudentRepository)
    {
        $this->PaymentFeeStudentRepository = $PaymentFeeStudentRepository;
    }

    public function index()
    {
        return $this->PaymentFeeStudentRepository->all();
    }

    public function show($id)
    {
        return $this->PaymentFeeStudentRepository->find($id);
    }

    public function store(StoreReceiptProcessFeeStudentRequest $request)
    {
        return $this->PaymentFeeStudentRepository->create($request->validated());
    }

    public function update(StoreReceiptProcessFeeStudentRequest $request, $id)
    {
        return $this->PaymentFeeStudentRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->PaymentFeeStudentRepository->destroy($id);
    }

   
}
