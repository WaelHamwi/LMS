<?php

namespace App\Repositories\Student;

use App\Models\Fees;
use App\Models\Section;
use App\Models\Classroom;
use App\Models\AcademicLevel;

class FeesRepository implements FeesRepositoryInterface
{
    public function getAllFees()
    {
        $sections = section::all();
        $academicLevels = AcademicLevel::all();
        $classrooms = Classroom::all();
        $fees = Fees::all();
        return view('Students.Fees', compact('sections', 'academicLevels', 'classrooms', 'fees'));
    }

    public function createFee(array $data)
    {
        try {
            foreach ($data['title'] as $key => $value) {
                Fees::create([
                    'title' => $value,
                    'amount' => $data['amount'][$key] ?? null,
                    'academic_level_id' => $data['academic_level_id'][$key] ?? null,
                    'classroom_id' => $data['classroom_id'][$key] ?? null,
                    'section_id' => $data['section_id'][$key] ?? null,
                    'year' => $data['year'][$key] ?? null,
                    'description' => $data['description'][$key] ?? null,
                    'fee_type' => $data['fee_type'][$key] ?? null,
                ]);
            }

            return redirect()->route('fees.index')->with('success', 'Fee(s) created successfully.');
        } catch (Exception $e) {
            return redirect()->route('fees.index')->with('error', 'Failed to create fee(s): ' . $e->getMessage());
        }
    }


    public function getFeeById($id)
    {
        return Fees::findOrFail($id);
    }

    public function updateFee($id, array $data)
    {
        try {
            $fee = Fees::findOrFail($id);
            $fee->update([
                'title' => $data['title'][0] ?? null,
                'amount' => $data['amount'][0] ?? null,
                'academic_level_id' => $data['academic_level_id'][0] ?? null,
                'classroom_id' => $data['classroom_id'][0] ?? null,
                'section_id' => $data['section_id'][0] ?? null,
                'year' => $data['year'][0] ?? null,
                'description' => $data['description'][0] ?? null,
                'fee_type' => $data['fee_type'][0] ?? null,
            ]);

            return redirect()->route('fees.index')->with('success', 'Fee updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('fees.index')->with('error', 'Failed to update fee: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $fee = Fees::findOrFail($id);
            $fee->delete();
            return redirect()->route('fees.index')->with('success', 'Fee deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('fees.index')->with('error', 'Failed to delete fee: ' . $e->getMessage());
        }
    }
    public function bulkDelete(array $ids)
    {
        try {
            Fees::whereIn('id', $ids)->delete();
            return redirect()->route('fees.index')->with('success', 'Fees have been deleted successfully.');
        } catch (\Exception $e) {
            toastr()->error(__('Failed to delete the fees: ') . $e->getMessage());
            return redirect()->route('fees.index');
        }
    }

}
