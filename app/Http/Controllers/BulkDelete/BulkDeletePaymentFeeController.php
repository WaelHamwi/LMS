<?php

namespace App\Http\Controllers\BulkDelete;

use App\Models\PaymentFee;
use Illuminate\Http\Request;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;
use Illuminate\Support\Facades\Log; // Add the Log facade

class BulkDeletePaymentFeeController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {

        $ids = $request->input('ids');

        if (empty($ids)) {

            return response()->json(['error' => 'No IDs provided'], 400);
        }





        try {
            $result = parent::bulkDeleteBase($ids, PaymentFee::class);

            return response()->json($result);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Bulk delete failed'], 500);
        }
    }
}
