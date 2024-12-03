<?php

namespace App\Http\Controllers\Student;
use App\Models\Fees;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeesRequest;
use App\Repositories\student\FeesRepositoryInterface;
use Illuminate\Support\Facades\Log;
class FeesController extends Controller
{
    protected $feesRepository;

    public function __construct(FeesRepositoryInterface $feesRepository)
    {
        $this->feesRepository = $feesRepository;
    }

    public function index()
    {
        return $this->feesRepository->getAllFees();
    }

    public function store(StoreFeesRequest $request)
    {
        return $this->feesRepository->createFee($request->validated());
    }

    public function show($id)
    {
        return $this->feesRepository->getFeeById($id);
    }

    public function update(StoreFeesRequest $request, $id)
    {
        return $this->feesRepository->updateFee($id, $request->validated());
    }

    public function destroy(Fees $Fees)
    {
        return $this->feesRepository->delete($Fees);
    }
    public function bulkDelete()
    {
           Log::info('Bulk delete initiated ');
        $ids = request()->input('ids', []);
        Log::info('Bulk delete initiated for the following IDs:', ['ids' => $ids]);
        return $this->feesRepository->bulkDelete($ids);
      
    }
}
