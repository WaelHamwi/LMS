@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Fee Invoices & Student Accounts</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL('dashboard/parent') }}">Parent</a></li>
                            <li class="breadcrumb-item active">Fee Invoices & Accounts</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fee Invoices Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">Students' Fee Invoices</h4>
                @if ($students->isEmpty())
                <div class="alert alert-warning">
                    No fee invoices found for your students.
                </div>
                @else
                <ul>
                    @foreach ($students as $student)
                    <li>
                        <strong>{{ $student->name }}</strong>
                        <ul>
                            @if ($student->feeInvoices->isEmpty())
                            <li>No invoices found.</li>
                            @else
                            @foreach ($student->feeInvoices as $invoice)
                            <li>Invoice ID: {{ $invoice->id ?? 'No Entry' }} | Amount: ${{ number_format($invoice->amount ?? 0, 2) }}</li>
                            @endforeach
                            @endif
                        </ul>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>

        <!-- Student Accounts Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">Student Accounts</h4>
                @if ($studentAccounts->isEmpty())
                <div class="alert alert-warning">
                    No student account data available.
                </div>
                @else
                <div class="table-responsive">
                    <table class="datatable table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Fee Invoice ID</th>
                                <th>Receipt ID</th>
                                <th>Payment ID</th>
                                <th>Processing ID</th>
                                <th>Student ID</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Description</th>
                                <th>Balance</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studentAccounts as $account)
                            <tr>
                                <td>{{ $account->id ?? 'No Entry' }}</td>
                                <td>{{ $account->date ?? 'No Entry' }}</td>
                                <td>{{ $account->type ?? 'No Entry' }}</td>
                                <td>{{ $account->fee_invoice_id ?? 'No Entry' }}</td>
                                <td>{{ $account->receipt_id ?? 'No Entry' }}</td>
                                <td>{{ $account->payment_id ?? 'No Entry' }}</td>
                                <td>{{ $account->processing_id ?? 'No Entry' }}</td>
                                <td>{{ $account->student_id ?? 'No Entry' }}</td>
                                <td>{{ $account->debit !== null ? number_format($account->debit, 2) : 'No Entry' }}</td>
                                <td>{{ $account->credit !== null ? number_format($account->credit, 2) : 'No Entry' }}</td>
                                <td>{{ $account->description ?? 'No Entry' }}</td>
                                <td>{{ $account->balance !== null ? number_format($account->balance, 2) : 'No Entry' }}</td>
                                <td>{{ $account->created_at ?? 'No Entry' }}</td>
                                <td>{{ $account->updated_at ?? 'No Entry' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<footer>
    <p>Copyright © 2022 Dreamguys.</p>
</footer>
</div>
@endsection
