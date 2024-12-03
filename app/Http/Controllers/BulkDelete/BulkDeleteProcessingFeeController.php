<?php
namespace App\Http\Controllers\BulkDelete;

use App\Models\ProcessingFee; 
use Illuminate\Http\Request;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;

class BulkDeleteProcessingFeeController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        return parent::bulkDeleteBase($ids, ProcessingFee::class);
    }
}
