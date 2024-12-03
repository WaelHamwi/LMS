<?php

namespace App\Repositories\Teacher;
use Illuminate\Http\Request;
interface QuestionRepositoryInterface
{
    public function index();

    public function store(Request $request);


    public function update(Request $request, $id);

    public function destroy($request);
}
