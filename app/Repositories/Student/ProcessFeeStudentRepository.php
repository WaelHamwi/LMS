<?php

namespace App\Repositories\Student;

use App\Models\ProcessingFee;
use App\Models\StudentAccount;
use App\Models\FundAccount;
use App\Models\Student;
use App\Models\Fees;
use Illuminate\Support\Facades\DB;

class ProcessFeeStudentRepository implements ProcessFeeStudentRepositoryInterface
{
    public function all()
    {
        try {
            $ProcessingFeeStudents = ProcessingFee::all();
            $students = Student::all();
            $fees = Fees::all();
            return view('Students.ProcessingFeeStudents', compact('ProcessingFeeStudents', 'students', 'fees'));
        } catch (\Exception $e) {
            return redirect()->route('processingFeeStudents.index')->with('error', 'Error fetching data');
        }
    }

    public function find($id)
    {
        try {
            return ProcessingFee::findOrFail($id);
        } catch (\Exception $e) {
            return redirect()->route('processingFeeStudents.index')->with('error', 'Process fee student not found');
        }
    }

    public function create(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $studentIds = is_array($data['student_id']) ? $data['student_id'] : [$data['student_id']];
                $credits = is_array($data['credit']) ? $data['credit'] : [$data['credit']];
                $descriptions = is_array($data['description']) ? $data['description'] : [$data['description']];

                foreach ($studentIds as $index => $studentId) {
                    $credit = $credits[$index] ?? $credits[0];
                    $description = $descriptions[$index] ?? $descriptions[0];
                    $processFee = ProcessingFee::create([
                        'student_id' => $studentId,
                        'debit' => $credit,
                        'date' => now(),
                        'description' => $description,
                    ]);

                    $processFeeId = $processFee->id;


                    StudentAccount::create([
                        'student_id' => $studentId,
                        'date' => now(),
                        'type' => 'fee_processing',
                        'credit' => 0,
                        'processing_id' => $processFeeId,
                        'debit' => $credit,
                        'description' => 'Process Fee: ' . ($description ?? ''),
                    ]);
                }

                return redirect()->route('processingFeeStudents.index')->with('success', 'Process fee students have been created');
            });
        } catch (\Exception $e) {
            return redirect()->route('processingFeeStudents.index')->with('error', 'Error creating process fee students' . $e);
        }
    }

    public function update($id, array $data)
    {
        try {
          
            return DB::transaction(function () use ($id, $data) {
                $processFee = $this->find($id);

                $processFee->update([
                    'student_id' => $data['student_id'][0],
                    'debit' => $data['credit'][0],
                    'date' => now(),
                    'description' => $data['description'][0],
                ]);

                $studentAccount = StudentAccount::where('type', 'fee_processing')
                    ->where('student_id', $processFee->student_id)
                    ->where('processing_id', $id)
                    ->first();

                if ($studentAccount) {
                    $studentAccount->update([
                        'debit' =>  $data['credit'][0],
                        'credit' => 0,
                        'date' => now(),
                        'description' => 'Process Fee: ' . ($data['description'][0] ?? ''),
                    ]);
                }


                return redirect()->route('processingFeeStudents.index')->with('success', 'Process fee student updated successfully');
            });
        } catch (\Exception $e) {
            return redirect()->route('processingFeeStudents.index')->with('error', 'Error updating process fee student');
        }
    }

    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $processFee = $this->find($id);

                StudentAccount::where('type', 'fee_processing')
                    ->where('student_id', $processFee->student_id)
                    ->where('debit', $processFee->debit)
                    ->delete();

                $processFee->delete();

                return redirect()->route('processingFeeStudents.index')->with('success', 'Process fee student deleted successfully');
            });
        } catch (\Exception $e) {
            return redirect()->route('processingFeeStudents.index')->with('error', 'Error deleting process fee student');
        }
    }
}
