<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\Teacher\ExamRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\ExamRequest; 
class ExamController extends Controller
{

    protected $Exam;

    public function __construct(ExamRepositoryInterface $Exam)
    {
        $this->Exam = $Exam;
    }

    public function index()
    {
        return $this->Exam->index();
    }

    public function create()
    {
        return $this->Exam->create();
    }


    public function store(ExamRequest  $request)
    {
        return $this->Exam->store($request);
    }

    public function show($id) {}


    public function update(ExamRequest  $request, $id)
    {
        return $this->Exam->update($request, $id);
    }

    public function destroy(Request $request)
    {
        return $this->Exam->destroy($request);
    }
}
