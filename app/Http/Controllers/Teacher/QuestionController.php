<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\Teacher\QuestionRepositoryInterface;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $questionRepo;

    public function __construct(QuestionRepositoryInterface $questionRepo)
    {
        $this->questionRepo = $questionRepo;
    }

    public function index()
    {
        return $this->questionRepo->index();
    }

    public function store(Request $request)
    {
        return $this->questionRepo->store($request);
    }

    public function show($id)
    {
        return $this->questionRepo->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->questionRepo->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->questionRepo->destroy($id);
    }
}
