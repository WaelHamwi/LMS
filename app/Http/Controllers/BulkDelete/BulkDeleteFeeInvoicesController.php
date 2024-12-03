<?php
namespace App\Http\Controllers\BulkDelete;

use App\Models\FeeInvoice;
use Illuminate\Http\Request;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;


class BulkDeleteFeeInvoicesController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        
        return parent::bulkDeleteBase($ids, FeeInvoice::class);
    }
}
