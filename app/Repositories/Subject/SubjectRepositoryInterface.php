<?php

namespace App\Repositories\Subject;

use Illuminate\Http\Request;

interface SubjectRepositoryInterface
{
    public function index();
    public function show($id);
    public function store(Request $request);
    public function update(Request $request, $id);
    public function destroy($id);
}
