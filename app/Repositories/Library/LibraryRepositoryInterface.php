<?php

namespace App\Repositories\Library;

use Illuminate\Http\Request;

interface LibraryRepositoryInterface
{
    public function index();

    public function create();

    public function store($request);

    public function edit($id);

    public function update(Request $request);

    public function destroy(Request $request);

    public function download($filename);
}
