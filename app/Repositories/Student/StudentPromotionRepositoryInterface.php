<?php

namespace App\Repositories\Student;

use Illuminate\Http\Request;

interface StudentPromotionRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function promoteList();
    public function destroy($id);
    public function bulkDelete(array $ids);
    public function getStudentAcademicDetails(Request $request);
}
