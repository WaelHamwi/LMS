<?php

namespace App\Repositories\Student;

use App\Models\ReceiptStudent;
use App\Models\StudentAccount;
use App\Models\FundAccount;
use App\Models\Student;
use App\Models\Fees;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReceiptStudentRepository implements ReceiptStudentRepositoryInterface
{
    public function all()
    {
        try {
            $receiptStudents = ReceiptStudent::all();
            $students = Student::all();
            $fees = Fees::all();
            return view('Students.ReceiptStudents', compact('receiptStudents', 'students', 'fees'));
        } catch (\Exception $e) {
            Log::error('Error fetching all receipt students: ' . $e->getMessage());
            return redirect()->route('receiptStudents.index')->with('error', 'Error fetching data');
        }
    }

    public function find($id)
    {
        try {
            return ReceiptStudent::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error finding receipt student: ' . $e->getMessage());
            return redirect()->route('receiptStudents.index')->with('error', 'Receipt student not found');
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
                    $credit = $credits[0];
                    $description = $descriptions[0];
    
                    $receiptStudent = ReceiptStudent::create([
                        'student_id' => $studentId,
                        'credit' => $credit,
                        'date' => now(),
                        'description' => $description,
                    ]);
    
                    $receiptStudentId = $receiptStudent->id;
    
                    FundAccount::create([
                        'student_id' => $studentId,
                        'debit' => $credit,
                        'credit' => 0,
                        'date' => now(),
                        'receipt_id' => $receiptStudentId,
                        'description' => 'Funding Account: ' . ($description ?? ''),
                    ]);
    
                    StudentAccount::create([
                        'student_id' => $studentId,
                        'date' => now(),
                        'type' => 'payment_received',
                        'credit' => $credit,
                        'receipt_id' => $receiptStudentId,
                        'debit' => 0,
                        'description' => 'Receipt: ' . ($description ?? ''),
                    ]);
                }
    
                return redirect()->route('receiptStudents.index')->with('success', 'Receipt students have been created');
            });
        } catch (\Exception $e) {
            Log::error('Error creating receipt students: ' . $e->getMessage());
            return redirect()->route('receiptStudents.index')->with('error', 'Error creating receipt students');
        }
    }
    

    public function update($id, array $data)
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $receiptStudent = $this->find($id);
                
                $receiptStudent->update([
                    'student_id' => $data['student_id'][0],
                    'credit' => $data['credit'][0],
                    'debit' => 0,
                    'date' => now(),
                    'description' => $data['description'][0],
                ]);
    
                $studentAccount = StudentAccount::where('type', 'payment_received')
                    ->where('student_id', $receiptStudent->student_id)
                    ->where('receipt_id', $id)
                    ->first();
    
                if ($studentAccount) {
                    $studentAccount->update([
                        'debit' => 0,
                        'credit' => $data['credit'][0],
                        'date' => now(),
                        'description' => 'Receipt: ' . ($data['description'][0] ?? ''),
                    ]);
                }
    
                $fundAccount = FundAccount::where('student_id', $receiptStudent->student_id)
                    ->where('receipt_id', $id)
                    ->first();
    
                if ($fundAccount) {
                    $fundAccount->update([
                        'debit' => $data['credit'][0],
                        'credit' => 0,
                        'date' => now(),
                        'description' => 'Funding Account: ' . ($data['description'][0] ?? ''),
                    ]);
                }
    
                return redirect()->route('receiptStudents.index')->with('success', 'Receipt student updated successfully');
            });
        } catch (\Exception $e) {
            Log::error('Error updating receipt student: ' . $e->getMessage());
            return redirect()->route('receiptStudents.index')->with('error', 'Error updating receipt student');
        }
    }
    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $receiptStudent = $this->find($id);

                StudentAccount::where('type', 'receipt')
                    ->where('student_id', $receiptStudent->student_id)
                    ->where('debit', $receiptStudent->debit)
                    ->delete();

                $receiptStudent->delete();

                return redirect()->route('receiptStudents.index')->with('success', 'Receipt student deleted successfully');
            });
        } catch (\Exception $e) {
            Log::error('Error deleting receipt student: ' . $e->getMessage());
            return redirect()->route('receiptStudents.index')->with('error', 'Error deleting receipt student');
        }
    }
    public function bulkDelete(array $ids)
    {
        try {
            Fees::whereIn('id', $ids)->delete();
            return redirect()->route('receiptStudents.index')->with('success', 'receipt student has been deleted successfully.');
        } catch (\Exception $e) {
            toastr()->error(__('Failed to delete the receipt student: ') . $e->getMessage());
            return redirect()->route('receiptStudents.index');
        }
    }
}
