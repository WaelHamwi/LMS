<?php

namespace App\Repositories\Library;

use App\Helpers\Upload\UploadHelper;
use App\Models\Library;
use App\Models\AcademicLevel;
use App\Models\Section;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;

class LibraryRepository implements LibraryRepositoryInterface
{
    public function index()
    {
        $books = Library::all();
        $academicLevels = AcademicLevel::all();
        $classrooms = Classroom::all();
        $sections = Section::all();
        $teachers = Teacher::all();
        return view('libraries.index', compact('books', 'academicLevels', 'classrooms', 'sections', 'teachers'));
    }

    public function create()
    {
        $academicLevels = AcademicLevel::all();
        return view('pages.library.create', compact('academicLevels'));
    }

    public function store($request)
    {
        try {
            $book = new Library();

            foreach ($request->input('title') as $index => $value) {
                $book->title = $value;
                $book->academic_level_id = $request->input('academic_level_id')[$index];
                $book->classroom_id = $request->input('classroom_id')[$index];
                $book->section_id = $request->input('section_id')[$index];
                $book->teacher_id = $request->input('teacher_id')[$index];

                if ($request->hasFile('file_name') && isset($request->file('file_name')[$index])) {
                    $book->file_name = $request->file('file_name')[$index]->getClientOriginalName();
                    UploadHelper::uploadFile($request, 'file_name', 'library');
                }
                $book->save();
            }

            toastr()->success('Book successfully added.');
            return redirect()->route('libraries.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $academicLevels = AcademicLevel::all();
        $book = Library::findOrFail($id);
        return view('pages.library.edit', compact('book', 'academicLevels'));
    }

    public function update(Request $request)
    {
        try {
            $id = basename($request->path());
            $book = Library::findOrFail(  $id);

            $book->title = $request->input('title')[0];
            $book->academic_level_id = $request->input('academic_level_id')[0];
            $book->classroom_id = $request->input('classroom_id')[0];
            $book->section_id = $request->input('section_id')[0];
            $book->teacher_id = $request->input('teacher_id')[0];

            if ($request->hasFile('file_name')) {
                UploadHelper::deleteFile($book->file_name, 'library');
                foreach ($request->file('file_name') as $file) {
                    UploadHelper::uploadFile($request, 'file_name', 'library');
                    $book->file_name = $file->getClientOriginalName();
                }
            }

            $book->teacher_id = 1;
            $book->save();

            toastr()->success('Book successfully updated.');
            return redirect()->route('libraries.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


    public function destroy(Request $request)
    {
        $id = basename($request->path());

        $library = Library::find($id);

        if ($library) {
            UploadHelper::deleteFile($library->file_name, 'library');

            $library->delete();

            toastr()->error('Book successfully deleted.');
        } else {
            toastr()->error('Failed to delete the book. Library not found.');
        }

        return redirect()->route('libraries.index');
    }



    public function download($filename)
    {
        return response()->download(public_path('attachments/library/' . $filename));
    }
}
