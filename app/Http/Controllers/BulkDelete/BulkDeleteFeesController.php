<?php
namespace App\Http\Controllers\BulkDelete;

use App\Models\Fees;
use Illuminate\Http\Request;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;


class BulkDeleteFeesController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        return parent::bulkDeleteBase($ids, Fees::class);
    }
}
