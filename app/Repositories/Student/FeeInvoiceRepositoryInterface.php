<?php

namespace App\Repositories\Student;

use App\Models\FeeInvoice;
use Illuminate\Http\Request;

interface FeeInvoiceRepositoryInterface
{
    public function index(Request $request);

    public function find($id) ;

    public function create(array $data);

    public function update($id, array $data);

    public function destroy(FeeInvoice $FeeInvoice);
   
}