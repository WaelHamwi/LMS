<?php
namespace App\Http\Controllers\BulkDelete;

use App\Models\ReceiptStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;


class BulkDeleteRecieptController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        return parent::bulkDeleteBase($ids, ReceiptStudent::class);
    }
}
