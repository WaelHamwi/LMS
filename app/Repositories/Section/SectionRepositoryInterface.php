<?php

namespace App\Repositories\Section;

use App\Http\Requests\StoreSections;
use App\Models\Section;
use Illuminate\Http\Request;
interface SectionRepositoryInterface
{
    public function index(Request $request);
    public function create(StoreSections $request);
    public function store(StoreSections $request);
    public function show(Section $section);
    public function edit(Section $section);
    public function update(StoreSections $request, Section $section);
    public function destroy(Section $section);
    public function bulkDelete(array $ids);

}
