@extends('layouts.master')

@section('content')

<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">

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
                        <h3 class="page-title">Fees</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Fees</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Fee</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#fee-modal" id="add-fee">ADD FEE</button>
                    </div>

                    @include('components.modal', [
                    'modalId' => 'fee-modal',
                    'modalTitle' => 'Add New Fee',
                    'formId' => 'fee-form',
                    'formAction' => route('fees.store'),
                    'fields' => [
                        [
                            'id' => 'field-1-title',
                            'label' => 'Fee Title',
                            'name' => 'title',
                            'type' => 'text',
                            'placeholder' => 'Enter fee title',
                            'required' => true,
                        ],
                        [
                            'id' => 'field-2-fee-type',
                            'label' => 'Fee Type',
                            'name' => 'fee_type',
                            'type' => 'text',
                            'placeholder' => 'Enter fee type',
                            'required' => true,
                        ],
                        [
                            'id' => 'field-3-amount',
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
                            'id' => 'field-7-description',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'placeholder' => 'Enter description',
                            'required' => false,
                        ],
                        [
                            'id' => 'field-8-year',
                            'label' => 'Year',
                            'name' => 'year',
                            'type' => 'text',
                            'placeholder' => 'Enter year',
                            'required' => true,
                        ],
                    ],
                    'saveBtn' => 'save-button-fee'
                    ])
                </div>
            </div>

            @php
            $headers = ['ID', 'Title', 'Fee Type', 'Amount', 'Academic Level', 'Section', 'Classroom', 'Year', 'Description'];
            $modelName = 'Fee';
            $routeDestroy = 'fees.destroy';
            $rows = $fees->map(function ($fee) {
                return [
                    'id' => $fee->id,
                    'data' => [
                        $fee->id,
                        $fee->title,
                        $fee->fee_type, 
                        $fee->amount, 
                        $fee->academicLevel->name,
                        $fee->section->name,
                        $fee->classroom->name,
                        $fee->year,
                        $fee->description,
                    ],
                ];
            })->toArray();

            $actionButtons = function ($row) {
          
                return '
                <button class="btn btn-rounded btn-warning edit-fee"
                    data-bs-toggle="modal"
                    data-bs-target="#fee-modal"
                    data-id="' . $row['data'][0] . '"
                    data-title="' . $row['data'][1] . '"
                    data-fee-type="' . $row['data'][2] . '"
                    data-amount="' . $row['data'][3] . '" 
                    data-academic-level="' . $row['data'][4] . '"
                    data-section="' . $row['data'][5] . '"
                    data-classroom="' . $row['data'][6] . '"
                    data-year="' . $row['data'][7] . '"
                    data-description="' . $row['data'][8] . '">
                    Edit
                </button>

                <form action="' . route('fees.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                        data-title="Delete Fee"
                        data-body="Are you sure you want to delete this fee?"
                        data-action="delete"
                        data-url="/fees/' . $row['data'][0] . '">
                        Delete
                    </button>
                </form>
                ';
            };
            @endphp

            @include('components.data-table', [
                'title' => 'Fees',
                'description' => 'Add a new fee to the table',
                'headers' => $headers,
                'rows' => $rows,
                'modelName' => $modelName,
                'routeDestroy' => $routeDestroy,
                'actionButtons' => $actionButtons,
                'bulkDelete' => 'fees'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection
