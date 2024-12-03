<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\student\StudentGraduatedRepositoryInterface;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class GraduatedController extends Controller
{
    protected $graduatedRepository;

    public function __construct(StudentGraduatedRepositoryInterface $graduatedRepository)
    {
        $this->graduatedRepository = $graduatedRepository;
    }

    public function index(Request $request)
    {
        if ($request->has('bulk')) {
            return $this->graduatedRepository->bulkIndex();
        }

        // Otherwise handle regular graduation index
        return $this->graduatedRepository->index();
    }

    public function create()
    {
        return $this->graduatedRepository->create();
    }

    public function store(Request $request)
    {


        if ($request->has('bulk')) {
            return $this->graduatedRepository->bulkStore($request->all());
        }


        return $this->graduatedRepository->store($request->all());
    }

    public function show($id)
    {
        return $this->graduatedRepository->show($id);
    }

    public function update(Request $request, $id)
    {
        if ($request->has('return_data')) {
            return $this->graduatedRepository->ReturnData($id);
        }
        return $this->graduatedRepository->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->graduatedRepository->destroy($id);
    }

    public function SoftDelete($request)
    {
        return $this->graduatedRepository->SoftDelete($request);
    }

    public function bulkIndex()
    {
        return $this->graduatedRepository->bulkIndex();
    }
    public function ReturnData($request)
    {
        return $this->graduatedRepository->ReturnData($request);
    }
    public function bulkDelete()
    {
       
        $ids = request()->input('ids', []);
        Log::info('bulkDelete called with IDs: ' . implode(', ', $ids));

        return $this->graduatedRepository->bulkDelete($ids);
    }
}
