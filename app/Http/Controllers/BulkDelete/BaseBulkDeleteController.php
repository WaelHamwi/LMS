<?php

namespace App\Http\Controllers\BulkDelete;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BaseBulkDeleteController extends Controller
{
    protected function bulkDeleteBase($ids, $model)
    {
        Log::info('Query for deletion:', [
            'ids' => $ids,
            'model' => $model,
            'query' => $model::whereIn('id', $ids)->toSql(),
        ]);
        $modelName = class_basename($model);

        try {
            if (empty($ids)) {
                return redirect()->back()->with('error', 'No items selected for deletion.');
            }

            $model::whereIn('id', $ids)->delete();
            toastr()->success("{$modelName} records deleted successfully.");
        } catch (\Exception $e) {
            toastr()->error(__('Failed to delete the ' . $modelName . ': ') . $e->getMessage());

            return redirect()->route(strtolower($modelName) . '.index');
        }
    }
}
