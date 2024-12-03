@extends('layouts.master')

@section('content')

<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">

        @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-4 custom-alert" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-4 custom-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Invoice Types</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Invoice Types</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Invoice Type</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#Invoice-type-modal" id="add-invoice-type">ADD Invoice TYPE</button>
                    </div>

                    @include('components.modal', [
                    'modalId' => 'Invoice-type-modal',
                    'modalTitle' => 'Add New Invoice Type',
                    'formId' => 'invoice-type-form',
                    'formAction' => route('fee_invoices.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-title',
                    'label' => 'Invoice Type Title',
                    'name' => 'title',
                    'type' => 'text',
                    'placeholder' => 'Enter Invoice type title',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-2-amount',
                    'label' => 'Amount',
                    'name' => 'amount',
                    'type' => 'number',
                    'placeholder' => 'Enter amount',
                    'required' => true,
                    'step' => '0.01',
                    ],
                   
                    [
                    'id' => 'field-7-student-academic-level',
                    'label' => 'Academic Level',
                    'name' => 'academic_level_id',
                    'type' => 'select',
                    'options' => $academicLevels->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select academic level',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-8-student-classroom',
                    'label' => 'Classroom',
                    'name' => 'classroom_id',
                    'type' => 'select',
                    'options' => $classrooms->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select classroom',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-9-student-section',
                    'label' => 'Section',
                    'name' => 'section_id',
                    'type' => 'select',
                    'options' => $sections->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select section',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-1-student-id',
                    'label' => 'Student',
                    'name' => 'student_id',
                    'type' => 'select',
                    'options' => $students->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select student',
                    'required' => true,
                    ],

                    [
                    'id' => 'field-6-fee',
                    'label' => 'Fee',
                    'name' => 'fee_id',
                    'type' => 'select',
                    'options' => $fees->pluck('title', 'id')->toArray(),
                    'placeholder' => 'Select fee',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-7-year',
                    'label' => 'Year',
                    'name' => 'year',
                    'type' => 'text',
                    'placeholder' => 'Enter year',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-8-fee-type',
                    'label' => 'Fee Type',
                    'name' => 'fee_type',
                    'type' => 'select',
                    'options' => $fees->pluck('fee_type', 'id')->toArray(),
                    'placeholder' => 'Enter fee type',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-9-description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                    'placeholder' => 'Enter description',
                    'required' => false,
                    ],
                    ],
                    'saveBtn' => 'save-button-invoice-type'
                    ])
                </div>
            </div>

            @php
            $headers = ['ID', 'Title', 'Amount', 'Academic Level', 'Classroom','section', 'Student', 'Fee', 'Year', 'Fee Type', 'Description'];
            $modelName = 'Invoice Type';
            $routeDestroy = 'fee_invoices.destroy';
            $rows = $feeInvoices->map(function ($feeInvoice) {
            return [
            'id' => $feeInvoice->id,
            'data' => [
            $feeInvoice->id,
            $feeInvoice->title,
            $feeInvoice->amount,
            optional($feeInvoice->academicLevel)->name,
            optional($feeInvoice->classroom)->name,
            optional($feeInvoice->section)->name,
            optional($feeInvoice->student)->name,
            optional($feeInvoice->fee)->title,
            $feeInvoice->year,
            $feeInvoice->fee_type,
            $feeInvoice->description,
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {
            return '
            <button class="btn btn-rounded btn-warning edit-invoice-type"
                data-bs-toggle="modal"
                data-bs-target="#Invoice-type-modal"
                data-id="' . $row['data'][0] . '"
                data-title="' . $row['data'][1] . '"
                data-amount="' . $row['data'][2] . '"
                data-academic-level="' . $row['data'][3] . '"
                data-classroom="' . $row['data'][4] . '"
                data-section="' . $row['data'][5] . '"
                data-student="' . $row['data'][6] . '"
                data-fee="' . $row['data'][9] . '"
                data-year="' . $row['data'][8] . '"
                data-fee-type="' . $row['data'][9] . '"
                data-description="' . $row['data'][10] . '">
                Edit
            </button>

            <form action="' . route('fee_invoices.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    data-title="Delete Invoice Type"
                    data-body="Are you sure you want to delete this Invoice type?"
                    data-action="delete"
                    data-url="/fee_invoices/' . $row['data'][0] . '">
                    Delete
                </button>
            </form>
            ';
            };
            @endphp

            @include('components.data-table', [
            'title' => 'Invoice Types',
            'description' => 'Add a new Invoice type to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => 'fee_invoices'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection