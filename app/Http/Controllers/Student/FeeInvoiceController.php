<?php

namespace App\Http\Controllers\Student;

use App\models\FeeInvoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeeInvoices;
use App\Repositories\Student\FeeInvoiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeeInvoiceController extends Controller
{
    protected $feeInvoiceRepository;

    public function __construct(FeeInvoiceRepository $feeInvoiceRepository)
    {
        $this->feeInvoiceRepository = $feeInvoiceRepository;
    }

    public function index(Request $request)
    {

        return $this->feeInvoiceRepository->index($request);
    }

    public function store(StoreFeeInvoices $request)
    {
        return $this->feeInvoiceRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->feeInvoiceRepository->find($id);
    }

    public function update(StoreFeeInvoices $request, $id)
    {
        return $this->feeInvoiceRepository->update($id, $request->validated());
    }

    public function destroy(FeeInvoice $FeeInvoice)
    {
        return $this->feeInvoiceRepository->destroy($FeeInvoice);
    }
}
