<?php

namespace App\Repositories\Student;

use App\Models\PaymentFee;
use App\Models\StudentAccount;
use App\Models\FundAccount;
use App\Models\Student;
use App\Models\Fees;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentFeeStudentRepository implements PaymentFeeStudentRepositoryInterface
{
    public function all()
    {
        try {
            $PaymentFeeStudents = PaymentFee::all();
            $students = Student::all();
            $fees = Fees::all();
            return view('Students.PaymentFeeStudents', compact('PaymentFeeStudents', 'students', 'fees'));
        } catch (\Exception $e) {
            Log::error('Error fetching all Payment fee students: ' . $e->getMessage());
            return redirect()->route('paymentFeeStudents.index')->with('error', 'Error fetching data');
        }
    }

    public function find($id)
    {
        try {
            return PaymentFee::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error finding Payment fee student: ' . $e->getMessage());
            return redirect()->route('paymentFeeStudents.index')->with('error', 'Payment fee student not found');
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

                    $PaymentFee = PaymentFee::create([
                        'student_id' => $studentId,
                        'debit' => $credit,
                        'date' => now(),
                        'description' => $description,
                    ]);

                    $PaymentFeeId = $PaymentFee->id;
                    FundAccount::create([
                        'student_id' => $studentId,
                        'debit' => 0,
                        'credit' => $credit,
                        'date' => now(),
                        'payment_id' => $PaymentFeeId,
                        'description' => 'Funding Account: ' . ($description ?? ''),
                    ]);

                    StudentAccount::create([
                        'student_id' => $studentId,
                        'date' => now(),
                        'type' => 'payment_received',
                        'credit' => 0,
                        'payment_id' => $PaymentFeeId,
                        'debit' => $credit,
                        'description' => 'Payment Fee: ' . ($description ?? ''),
                    ]);
                }

                return redirect()->route('paymentFeeStudents.index')->with('success', 'Payment fee students have been created');
            });
        } catch (\Exception $e) {
            Log::error('Error creating Payment fee students: ' . $e->getMessage());
            return redirect()->route('paymentFeeStudents.index')->with('error', 'Error creating Payment fee students');
        }
    }

    public function update($id, array $data)
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $PaymentFee = $this->find($id);

                $PaymentFee->update([
                    'student_id' => $data['student_id'][0],
                    'credit' => $data['credit'][0],
                    'debit' => 0,
                    'date' => now(),
                    'description' => $data['description'][0],
                ]);

                $studentAccount = StudentAccount::where('type', 'payment_received')
                    ->where('student_id', $PaymentFee->student_id)
                    ->where('payment_id', $id)
                    ->first();

                if ($studentAccount) {
                    $studentAccount->update([
                        'debit' => 0,
                        'credit' => $data['credit'][0],
                        'date' => now(),
                        'description' => 'Payment Fee: ' . ($data['description'][0] ?? ''),
                    ]);
                }

                $fundAccount = FundAccount::where('student_id', $PaymentFee->student_id)
                    ->where('payment_id', $id)
                    ->first();

                if ($fundAccount) {
                    $fundAccount->update([
                        'debit' => $data['credit'][0],
                        'credit' => 0,
                        'date' => now(),
                        'description' => 'Funding Account: ' . ($data['description'][0] ?? ''),
                    ]);
                }

                return redirect()->route('paymentFeeStudents.index')->with('success', 'Payment fee student updated successfully');
            });
        } catch (\Exception $e) {
            Log::error('Error updating Payment fee student: ' . $e->getMessage());
            return redirect()->route('paymentFeeStudents.index')->with('error', 'Error updating Payment fee student');
        }
    }

    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $PaymentFee = $this->find($id);

                StudentAccount::where('type', 'payment_received')
                    ->where('student_id', $PaymentFee->student_id)
                    ->where('debit', $PaymentFee->debit)
                    ->delete();

                $PaymentFee->delete();

                return redirect()->route('paymentFeeStudents.index')->with('success', 'Payment fee student deleted successfully');
            });
        } catch (\Exception $e) {
            Log::error('Error deleting Payment fee student: ' . $e->getMessage());
            return redirect()->route('paymentFeeStudents.index')->with('error', 'Error deleting Payment fee student');
        }
    }
}
