<?php

namespace App\Repositories\Student;

use App\Models\FeeInvoice;
use App\Models\Fees;
use App\Models\Section;
use App\Models\Classroom;
use App\Models\AcademicLevel;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class FeeInvoiceRepository implements FeeInvoiceRepositoryInterface
{
    public function index(Request $request)
    {
        try {
            $sections = Section::all();
            $academicLevels = AcademicLevel::all();
            $classrooms = Classroom::all();
            $fees = Fees::all();
            $feeInvoices = FeeInvoice::all();
            $students = Student::all();
            return view('Students.FeeInvoices', compact('sections', 'academicLevels', 'classrooms', 'fees', 'feeInvoices', 'students'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve fee invoices: ' . $e->getMessage());
        }
    }

    public function find($id)
    {
        try {
            return FeeInvoice::find($id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to find the fee invoice: ' . $e->getMessage());
        }
    }



    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            foreach ($data['title'] as $key => $value) {
                $feeInvoice = FeeInvoice::create([
                    'title' => $value,
                    'amount' => $data['amount'][$key] ?? null,
                    'academic_level_id' => $data['academic_level_id'][$key] ?? null,
                    'classroom_id' => $data['classroom_id'][$key] ?? null,
                    'section_id' => $data['section_id'][$key] ?? null,
                    'year' => $data['year'][$key] ?? null,
                    'description' => $data['description'][$key] ?? null,
                    'student_id' => $data['student_id'][$key] ?? null,
                    'fee_id' => $data['fee_id'][$key] ?? null,
                    'fee_type' => $data['fee_type'][$key] ?? null,
                ]);

                StudentAccount::create([
                    'date' => now(),
                    'type' => 'fee_invoice',
                    'fee_invoice_id' => $feeInvoice->id,
                    'student_id' => $data['student_id'][$key] ?? null,
                    'debit' => $data['amount'][$key] ?? 0,
                    'credit' => 0,
                    'description' => $data['description'][$key] ?? 'Fee invoice entry',
                ]);
            }

            DB::commit();
            return redirect()->route('fee_invoices.index')->with('success', 'Fee invoice(s) created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create fee invoice(s): ' . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $feeInvoice = FeeInvoice::find($id);
            if ($feeInvoice) {
                $feeInvoice->update([
                    'title' => $data['title'][0] ?? null,
                    'amount' => $data['amount'][0] ?? null,
                    'academic_level_id' => $data['academic_level_id'][0] ?? null,
                    'classroom_id' => $data['classroom_id'][0] ?? null,
                    'section_id' => $data['section_id'][0] ?? null,
                    'year' => $data['year'][0] ?? null,
                    'description' => $data['description'][0] ?? null,
                    'student_id' => $data['student_id'][0] ?? null,
                    'fee_id' => $data['fee_id'][0] ?? null,
                    'fee_type' => $data['fee_type'][0] ?? null,
                ]);

                StudentAccount::updateOrCreate(
                    ['fee_invoice_id' => $feeInvoice->id],
                    [
                        'date' => now(),
                        'type' => 'fee_invoice',
                        'student_id' => $data['student_id'][0] ?? null,
                        'debit' => $data['amount'][0] ?? 0,
                        'description' => $data['description'][0] ?? 'Updated fee invoice entry',
                    ]
                );

                DB::commit();
                return redirect()->route('fee_invoices.index')->with('success', 'Fee invoice updated successfully.');
            }

            DB::rollBack();
            return redirect()->back()->with('error', 'Fee invoice not found.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update fee invoice: ' . $e->getMessage());
        }
    }


    public function destroy(FeeInvoice $FeeInvoice)
    {
        try {
            if ($FeeInvoice) {
                $FeeInvoice->delete();
                return redirect()->route('fee_invoices.index')->with('success', 'Fee invoice deleted successfully.');
            }
            return redirect()->back()->with('error', 'Fee invoice not found.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete fee invoice: ' . $e->getMessage());
        }
    }
}
