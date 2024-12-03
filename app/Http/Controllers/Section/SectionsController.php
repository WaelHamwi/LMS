<?php

namespace App\Http\Controllers\Section;

use App\Http\Requests\StoreSections;
use App\Repositories\Section\SectionRepositoryInterface;
use App\Models\Section;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    protected $SectionRepository;

    public function __construct(SectionRepositoryInterface $SectionRepository)
    {
        $this->SectionRepository = $SectionRepository;
    }

    public function index(Request $request)
    {
        return $this->SectionRepository->index($request);
    }

    public function create()
    {
        return $this->SectionRepository->create(new StoreSections());
    }

    public function store(StoreSections $request)
    {
        return $this->SectionRepository->store($request);
    }

    public function show(Section $section)
    {
        return $this->SectionRepository->show($section);
    }

    public function edit(Section $section)
    {
        return $this->SectionRepository->edit($section);
    }

    public function update(StoreSections $request, Section $section)
    {
        return $this->SectionRepository->update($request, $section);
    }

    public function destroy(Section $section)
    {
        return $this->SectionRepository->destroy($section);
    }

    public function bulkDelete()
    {
        $ids = request()->input('ids', []);
        return $this->SectionRepository->bulkDelete($ids);
    }
}
