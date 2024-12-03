<?php

namespace App\Repositories\student;

interface StudentGraduatedRepositoryInterface
{
    public function index();

    public function create();

    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);

    public function show();
    public function softDelete($request);
    public function bulkIndex();

    public function bulkStore(array $request);
    public function ReturnData($request);
    public function bulkDelete(array $ids);


    //public function restore($request);
}
