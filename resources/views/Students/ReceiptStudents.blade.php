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
                        <h3 class="page-title">Receipt Students</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Receipt Students</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Receipt Student</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#Receipt-student-modal" id="add-receipt-student">ADD Receipt Student</button>
                    </div>

                    @include('components.modal', [
                    'modalId' => 'Receipt-student-modal',
                    'modalTitle' => 'Add New Receipt Student',
                    'formId' => 'receipt-student-form',
                    'formAction' => route('receiptStudents.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-credit',
                    'label' => 'credit',
                    'name' => 'credit',
                    'type' => 'number',
                    'placeholder' => 'Enter credit',
                    'required' => true,
                    'step' => '0.01',
                    ],
                    [
                    'id' => 'field-2-student',
                    'label' => 'Student',
                    'name' => 'student_id',
                    'type' => 'select',
                    'options' => $students->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select student',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-3-description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                    'placeholder' => 'Enter description',
                    'required' => false,
                    ],
                    ],
                    'saveBtn' => 'save-button-receipt-student'
                    ])
                </div>
            </div>

            @php
            $headers = ['ID', 'Amount', 'Student', 'Year', 'Description'];
            $modelName = 'Receipt Student';
            $routeDestroy = 'receiptStudents.destroy';
            $rows = $receiptStudents->map(function ($receiptStudent) {
            return [
            'id' => $receiptStudent->id,
            'data' => [
            $receiptStudent->id,
            $receiptStudent->credit,
            optional($receiptStudent->student)->name,
            $receiptStudent->date,
            $receiptStudent->description,
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {
            return '
            <button class="btn btn-rounded btn-warning edit-receipt-student"
                data-bs-toggle="modal"
                data-bs-target="#Receipt-student-modal"
                data-id="' . $row['data'][0] . '"
                data-credit="' . $row['data'][1] . '"
                data-student="' . $row['data'][2] . '"
                data-date="' . $row['data'][3] . '"
                data-description="' . $row['data'][4] . '">
                Edit
            </button>

            <form action="' . route('receiptStudents.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    data-title="Delete Receipt Student"
                    data-body="Are you sure you want to delete this Receipt student?"
                    data-action="delete"
                    data-url="/receiptStudents/' . $row['data'][0] . '">
                    Delete
                </button>
            </form>
            ';
            };
            @endphp

            @include('components.data-table', [
            'title' => 'Receipt Students',
            'description' => 'Add a new Receipt student to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => 'receipt_students'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection
