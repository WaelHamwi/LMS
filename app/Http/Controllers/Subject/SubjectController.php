<?php

namespace App\Http\Controllers\Subject;

use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
{
    protected $subjectRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function index()
    {
        return $this->subjectRepository->index();
    }

    public function show($id)
    {
        return $this->subjectRepository->show($id);
    }

    public function store(SubjectRequest $request)
    {
        return $this->subjectRepository->store($request);
    }

    public function update(SubjectRequest $request, $id)
    {
        return $this->subjectRepository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->subjectRepository->destroy($id);
    }
}
