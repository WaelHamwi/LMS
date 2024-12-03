<?php
namespace App\Helpers\Upload;

use Illuminate\Support\Facades\Storage;

class UploadHelper
{
    /**
     * Upload a file to the specified folder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $name  The input field name
     * @param  string  $folder  The folder where the file should be stored
     * @return string  The file path or filename
     */
  
     public static function uploadFile( $request, $name, $folder)
     {
         $files = $request->file($name);
         if (!is_array($files)) {
             $files = [$files];
         }
 
         $file_names = [];
         foreach ($files as $file) {
             if ($file) {
                 $file_name = $file->getClientOriginalName();
                 $file->storeAs('attachments/' . $folder, $file_name, 'upload_attachments');
                 $file_names[] = $file_name;
             }
         }
 
         return count($file_names) === 1 ? $file_names[0] : $file_names;
     }

    /**
     * Delete a file from the storage.
     *
     * @param  string  $name  The name of the file
     * @param  string  $folder  The folder where the file is stored
     * @return void
     */
    public static function deleteFile($name, $folder)
    {
        $exists = Storage::disk('upload_attachments')->exists('attachments/'.$folder.'/'.$name);

        if ($exists) {
            Storage::disk('upload_attachments')->delete('attachments/'.$folder.'/'.$name);
        }
    }
}
