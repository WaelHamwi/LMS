<?php

namespace App\Repositories\Teacher;
use Illuminate\Http\Request;
interface ExamRepositoryInterface
{
    public function index();

    public function create();

    public function store($request);

    public function update(Request $request, $id);

    public function destroy($request);
}
