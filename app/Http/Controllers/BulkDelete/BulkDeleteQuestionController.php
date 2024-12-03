<?php

namespace App\Http\Controllers\BulkDelete;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;

class BulkDeleteQuestionController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        return parent::bulkDeleteBase($ids, Question::class);
    }
}
