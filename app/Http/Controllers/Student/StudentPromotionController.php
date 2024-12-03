<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Repositories\student\StudentPromotionRepositoryInterface;
use Illuminate\Http\Request;

class StudentPromotionController extends Controller
{
    protected $promotionRepository;

    public function __construct(StudentPromotionRepositoryInterface $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function index()
    {
        return $this->promotionRepository->index();
    }

    public function store(Request $request)
    {
        return $this->promotionRepository->store($request);
    }
    public function promoteList()
    {
        return $this->promotionRepository->promoteList();
    }
    public function bulkDelete()
    {
        $ids = request()->input('ids', []);
        return $this->promotionRepository->bulkDelete($ids);
    }
    public function destroy($id)
    {
        return $this->promotionRepository->destroy($id);
    }

    public function getStudentAcademicDetails(Request $request)
    {
        return $this->promotionRepository->getStudentAcademicDetails($request);
    }
    
}
