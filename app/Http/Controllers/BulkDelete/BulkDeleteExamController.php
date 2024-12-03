<?php
namespace App\Http\Controllers\BulkDelete;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;
use Illuminate\Support\Facades\Log;


class BulkDeleteExamController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {
        Log::info('Query for deletion:', [
           'request' => $request
        ]);
        $ids = $request->input('ids');
        
        return parent::bulkDeleteBase($ids, Exam::class);
    }
}
