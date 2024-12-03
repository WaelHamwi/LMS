<?php

namespace App\Http\Controllers\BulkDelete;

use App\Models\Library;
use Illuminate\Http\Request;
use App\Helpers\Upload\UploadHelper;
use App\Http\Controllers\BulkDelete\BaseBulkDeleteController;

class BulkDeleteLibraryController extends BaseBulkDeleteController
{
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        $this->deleteLibraryFiles($ids);
        return parent::bulkDeleteBase($ids, Library::class);
    }


    protected function deleteLibraryFiles($ids)
    {
        $libraries = Library::whereIn('id', $ids)->get();
        foreach ($libraries as $library) {
            UploadHelper::deleteFile($library->file_name, 'library');
        }
    }
}
