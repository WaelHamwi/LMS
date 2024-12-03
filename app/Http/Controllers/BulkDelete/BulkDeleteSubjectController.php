<?php
namespace App\Http\Controllers\BulkDelete;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;


class BulkDeleteSubjectController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        return parent::bulkDeleteBase($ids, Subject::class);
    }
}
