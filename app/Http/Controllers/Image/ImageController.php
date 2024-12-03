<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ImageController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'images.*' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
                'imageable_id' => 'required|integer',
                'imageable_type' => 'required|string',
            ]);

            $imageableId = $request->input('imageable_id');
            $imageableType = $request->input('imageable_type');

            if ($imageableType === 'App\Models\Student') {
                $student = \App\Models\Student::findOrFail($imageableId);

                if ($request->hasFile('images')) {

                    foreach ($request->file('images') as $file) {
                        $timestamp = time();
                        $name = $timestamp . '_' . $file->getClientOriginalName();
                        $file->storeAs('attachments/students/' . $student->name, $name, 'upload_attachments');

                        $image = new Image();
                        $image->filename = $name;
                        $image->imageable_id = $student->id;
                        $image->imageable_type = 'App\Models\Student';
                        $image->save();
                    }
                }

                return redirect()->back()->with('success', 'Images added successfully.');
            } else {
                return redirect()->back()->with('error', 'Invalid imageable type.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add images: ' . $e->getMessage());
        }
    }
    public function  storeTeacherImage(Request $request)
    {
        try {
            $request->validate([
                'images.*' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
                'imageable_id' => 'required|integer',
                'imageable_type' => 'required|string',
            ]);

            $imageableId = $request->input('imageable_id');
            $imageableType = $request->input('imageable_type');

            if ($imageableType === 'App\Models\Teacher') {

                $teacher = \App\Models\Teacher::findOrFail($imageableId);

                if ($request->hasFile('images')) {

                    foreach ($request->file('images') as $file) {
                        $timestamp = time();
                        $name = $timestamp . '_' . $file->getClientOriginalName();
                        $file->storeAs('attachments/teachers/' . $teacher->first_name, $name, 'upload_attachments');

                        $image = new Image();
                        $image->filename = $name;
                        $image->imageable_id = $teacher->id;
                        $image->imageable_type = 'App\Models\Teacher';
                        $image->save();
                    }
                }

                return redirect()->back()->with('success', 'Images added successfully.');
            } else {
                return redirect()->back()->with('error', 'Invalid imageable type.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add images: ' . $e->getMessage());
        }
    }
    public function  storeParentImage(Request $request)
    {
        try {
            $request->validate([
                'images.*' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
                'imageable_id' => 'required|integer',
                'imageable_type' => 'required|string',
            ]);

            $imageableId = $request->input('imageable_id');
            $imageableType = $request->input('imageable_type');

            if ($imageableType === 'App\Models\StudentParent') {

                $parent = \App\Models\StudentParent::findOrFail($imageableId);

                if ($request->hasFile('images')) {

                    foreach ($request->file('images') as $file) {
                        $timestamp = time();
                        $name = $timestamp . '_' . $file->getClientOriginalName();
                        $file->storeAs('attachments/parents/' . $parent->first_name, $name, 'upload_attachments');

                        $image = new Image();
                        $image->filename = $name;
                        $image->imageable_id = $parent->id;
                        $image->imageable_type = 'App\Models\StudentParent';
                        $image->save();
                    }
                }

                return redirect()->back()->with('success', 'Images added successfully.');
            } else {
                return redirect()->back()->with('error', 'Invalid imageable type.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add images: ' . $e->getMessage());
        }
    }
    public function updateTeacherImage(Request $request, $id)
    {
        try {
            $request->validate([
                'filename' => 'required|string|max:255',
                'imageable_id' => 'required|integer',
                'imageable_type' => 'required|string',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $image = Image::findOrFail($id);
            $oldFilePath = public_path('attachments/teachers/' . $image->imageable->first_name . '/' . $image->filename);

            if ($request->hasFile('image')) {
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                $newImage = $request->file('image');
                $newFilename = time() . '_' . $request->input('new_filename', $newImage->getClientOriginalName());
                $newImage->move(public_path('attachments/teachers/' . $image->imageable->first_name), $newFilename);

                $image->filename = $newFilename;
            }

            $image->imageable_id = $request->input('imageable_id');
            $image->imageable_type = $request->input('imageable_type');
            $image->save();

            return redirect()->back()->with('success', 'Teacher image updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update teacher image: ' . $e->getMessage());
        }
    }
    public function updateParentImage(Request $request, $id)
    {
        try {
            $request->validate([
                'filename' => 'required|string|max:255',
                'imageable_id' => 'required|integer',
                'imageable_type' => 'required|string',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $image = Image::findOrFail($id);
            $oldFilePath = public_path('attachments/parents/' . $image->imageable->first_name . '/' . $image->filename);

            if ($request->hasFile('image')) {
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                $newImage = $request->file('image');
                $newFilename = time() . '_' . $request->input('new_filename', $newImage->getClientOriginalName());
                $newImage->move(public_path('attachments/parents/' . $image->imageable->first_name), $newFilename);

                $image->filename = $newFilename;
            }

            $image->imageable_id = $request->input('imageable_id');
            $image->imageable_type = $request->input('imageable_type');
            $image->save();

            return redirect()->back()->with('success', 'Parent image updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update parent image: ' . $e->getMessage());
        }
    }   


    public function download($id)
    {
        try {
         
            $image = Image::findOrFail($id);
            $studentName = $image->imageable->name;
            $filePath = public_path('attachments/students/' . $studentName . '/' . $image->filename);
            return response()->download($filePath);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download image: ' . $e->getMessage());
        }
    }
    public function downloadTeacherImage($id)
    {
        try {
            $image = Image::findOrFail($id);
            $teacherName = Auth::guard()->user()->first_name; 
            $filePath = public_path('attachments/teachers/' . $teacherName . '/' . $image->filename);

            return response()->download($filePath);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download image: ' . $e->getMessage());
        }
    }

    public function downloadParentImage($id)
    {
        try {
            $image = Image::findOrFail($id);
            $parentName = Auth::guard()->user()->first_name; 
            $filePath = public_path('attachments/parents/' . $parentName . '/' . $image->filename);

            return response()->download($filePath);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download image: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $image = Image::findOrFail($id);
            $filePath = public_path('attachments/students/' . $image->imageable->name . '/' . $image->filename);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $image->delete();
            return redirect()->back()->with('success', 'Image deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete image: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'filename' => 'required|string|max:255',
                'imageable_id' => 'required|integer',
                'imageable_type' => 'required|string',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $image = Image::findOrFail($id);
            $oldFilePath = public_path('attachments/students/' . $image->imageable->name . '/' . $image->filename);

            if ($request->hasFile('image')) {
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                $newImage = $request->file('image');
                $newFilename = time() . '_' . $request->input('new_filename', $newImage->getClientOriginalName());
                $newImage->move(public_path('attachments/students/' . $image->imageable->name), $newFilename);

                $image->filename = $newFilename;
            }

            $image->imageable_id = $request->input('imageable_id');
            $image->imageable_type = $request->input('imageable_type');
            $image->save();

            return redirect()->back()->with('success', 'Image updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update image: ' . $e->getMessage());
        }
    }
}
