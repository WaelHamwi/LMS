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
                        <h3 class="page-title">Students</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Students</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Student</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-primary waves-effect waves-light mt-1" id="add-student">ADD STUDENT</button>
                    </div>


                    <div id="student-modal" class="modal-student" style="display: none;">
                        @include('components.form', [
                        'formId' => 'student-form',
                        'formAction' => route('students.store'),
                        'formTitle'=>'repeate the form',
                        'fields' => [
                        [
                        'id' => 'field-1-student-name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'placeholder' => 'Enter Full Name',
                        'required' => true,
                        ],
                        [
                        'id' => 'field-2-student-email',
                        'label' => 'Email',
                        'name' => 'email',
                        'type' => 'email',
                        'placeholder' => 'Enter Email',
                        'required' => true,
                        ],
                        [
                        'id' => 'field-3-student-gender',
                        'label' => 'Gender',
                        'name' => 'gender',
                        'type' => 'select',
                        'options' => ['male' => 'Male', 'female' => 'Female'],
                        'required' => true,
                        ],
                        [
                        'id' => 'field-4-student-blood',
                        'label' => 'Blood Type',
                        'name' => 'blood',
                        'type' => 'text',
                        'placeholder' => 'Enter Blood Type',
                        'required' => false,
                        ],
                        [
                        'id' => 'field-5-student-nationality',
                        'label' => 'Nationality',
                        'name' => 'nationality',
                        'type' => 'text',
                        'placeholder' => 'Enter Nationality',
                        'required' => false,
                        ],
                        [
                        'id' => 'field-6-student-dob',
                        'label' => 'Date of Birth',
                        'name' => 'date_of_birth',
                        'type' => 'date',
                        'placeholder' => 'Enter Date of Birth',
                        'required' => true,
                        ],
                        [
                        'id' => 'field-7-student-academic-level',
                        'label' => 'Academic Level',
                        'name' => 'academic_level_id',
                        'type' => 'select',
                        'options' => $academicLevels->pluck('name', 'id')->toArray(),
                        'required' => true,
                        ],
                        [
                        'id' => 'field-8-student-classroom',
                        'label' => 'Classroom',
                        'name' => 'classroom_id',
                        'type' => 'select',
                        'options' => $classrooms->pluck('name', 'id')->toArray(),
                        'required' => true,
                        ],
                        [
                        'id' => 'field-9-student-section',
                        'label' => 'Section',
                        'name' => 'section_id',
                        'type' => 'select',
                        'options' => $sections->pluck('name', 'id')->toArray(),
                        'required' => true,
                        ],
                        [
                        'id' => 'field-10-student-parent',
                        'label' => 'Parent',
                        'name' => 'parent_id',
                        'type' => 'select',
                        'options' => $parents->pluck('father_name', 'id')->toArray(),
                        'required' => false,
                        ],
                        [
                        'id' => 'field-11-student-academic-year',
                        'label' => 'Academic Year',
                        'name' => 'academic_year',
                        'type' => 'number',
                        'placeholder' => 'Enter Academic Year',
                        'required' => true,
                        ],
                        [
                        'id' => 'field-11-student-password',
                        'label' => 'password',
                        'name' => 'password',
                        'type' => 'password',
                        'placeholder' => 'Enter password',
                        'required' => false,
                        ],
                        [
                        'id' => 'field-12-student-image',
                        'label' => 'Student Image',
                        'name' => 'image[]',
                        'type' => 'file',
                        'placeholder' => 'Select an image',
                        'required' => false,
                        'accept' => 'image/*',
                        'multiple' => true,
                        ],
                        ],
                        ])
                        <button type="button" id="close-modal" class="btn btn-danger mt-2">Close</button>
                    </div>
                </div>
                @if($students->isEmpty())
                <div class="alert alert-warning mt-3">
                    There are no students to display.
                </div>
                @else
                @php
                $headers = [
                'ID',
                'Name',
                'Email',
                'Academic Level',
                'Class',
                'Date of Birth',
                'Gender',
                'Blood',
                'Nationality',
                'Section',
                'Parent',
                'Academic Year'
                ];
                $modelName = 'Student';
                $routeDestroy = 'students.destroy';

                $rows = $students->map(function ($student) {

                return [
                'id' => $student->id,
                'data' => [
                $student->id,
                $student->name,
                $student->email,
                $student->academicLevel ? $student->academicLevel->name : 'N/A',
                $student->classroom ? $student->classroom->name : 'N/A',
                $student->date_of_birth ?? 'N/A',
                $student->gender ?? 'N/A',
                $student->blood ?? 'N/A',
                $student->nationality ?? 'N/A',
                $student->section ? $student->section->name : 'N/A',
                $student->parent ? $student->parent->father_name : 'N/A',
                $student->academic_year ? $student->academic_year : 'N/A'
                ],
                ];
                })->toArray();

                $actionButtons = function ($row) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <button class="dropdown-item edit-student"
                                data-id="' . $row['data'][0] . '"
                                data-name="' . $row['data'][1] . '"
                                data-email="' . $row['data'][2] . '"
                                data-academic-level-id="' . $row['data'][3] . '"
                                data-classroom-id="' . $row['data'][4] . '"
                                data-date-of-birth="' . $row['data'][5] . '"
                                data-gender="' . $row['data'][6] . '"
                                data-blood="' . $row['data'][7] . '"
                                data-nationality="' . $row['data'][8] . '"
                                data-section-id="' . $row['data'][9] . '"
                                data-parent-id="' . $row['data'][10] . '"
                                data-academic-year="' . $row['data'][11] . '">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </li>
                        <li>
                            <div class="dropdown-item">
                                <form action="' . route('students.destroy', $row['data'][0]) . '" method="POST" style="display: inline;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="button" class="btn  text-danger p-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                        data-title="Delete Student"
                                        data-body="Are you sure you want to delete this student?"
                                        data-action="delete"
                                        data-url="/students/' . $row['data'][0] . '">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="' . route('students.show', $row['data'][0]) . '">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="' . route('fee_invoices.index') . '">
                                <i class="fas fa-list"></i> View Fee Voices
                            </a>
                        </li>
                        <button id="add-receipt-student" class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#Receipt-student-modal"
                            data-student-id="' . $row['data'][0] . '"
                            data-student-name="' . $row['data'][1] . '">
                            <i class="fas fa-receipt"></i> Add Receipt
                        </button>
                        <button id="add-paymentFee-student" class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#paymentFee-student-modal"
                            data-student-id="' . $row['data'][0] . '"
                            data-student-name="' . $row['data'][1] . '">
                            <i class="fas fa-hand-holding-usd"></i> Add paymentFee
                        </button>
                        <button id="add-processFee-student" class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#processFee-student-modal"
                            data-student-id="' . $row['data'][0] . '"
                            data-student-name="' . $row['data'][1] . '">
                            <i class="fas fa-dollar-sign"></i> Add processFee
                        </button>
                    </ul>
                </div>


                ';
                };
                @endphp

                @include('components.data-table', [
                'title' => 'Students',
                'description' => 'Add a new student to the table',
                'headers' => $headers,
                'rows' => $rows,
                'modelName' => $modelName,
                'routeDestroy' => $routeDestroy,
                'actionButtons' => $actionButtons,
                'bulkDelete' => 'students'
                ])
                @endif
            </div>

            @include('components.centered-modal', [
            'modalTitle' => 'Add Receipt for ',
            'modalId'=>'Receipt-student-modal',
            'label'=>'Receipt-student-modal-label',
            'formAction' => route('receiptStudents.store'),
            'formId' => 'receipt-form',
            'saveBtn' => 'Save Receipt',
            'fields' => [
            [
            'id' => 'field-1-credit',
            'label' => 'Credit',
            'name' => 'credit',
            'type' => 'number',
            'placeholder' => 'Enter credit',
            'required' => true,
            'step' => '0.01',
            'readonly' => false,
            ],
            [
            'id' => 'field-3-description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'placeholder' => 'Enter description',
            'required' => false,
            'readonly' => false,
            ],
            [
            'id' => 'field-2-student-receiptFee',
            'label' => '',
            'name' => 'student_id',
            'type' => 'hidden',
            'placeholder' => 'Select student',
            'required' => true,
            'readonly' => false,
            'value' =>"",
            ],
            [
            'id' => 'balance-label-receiptFee',
            'label' => 'Current Balance',
            'name' => 'balance',
            'type' => 'text',
            'placeholder' => 'Loading...',
            'required' => false,
            'readonly' => true,
            ],
            ]
            ])
            @include('components.centered-modal', [
            'modalTitle' => 'Add payment Fee for ',
            'modalId'=>'paymentFee-student-modal',
            'label'=>'paymentFee-student-modal-label',
            'formAction' => route('paymentFeeStudents.store'),
            'formId' => 'paymentFee-form',
            'saveBtn' => 'Save Payment Fee',
            'fields' => [
            [
            'id' => 'field-1-credit',
            'label' => 'Credit',
            'name' => 'credit',
            'type' => 'number',
            'placeholder' => 'Enter credit',
            'required' => true,
            'step' => '0.01',
            'readonly' => false,
            ],
            [
            'id' => 'field-3-description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'placeholder' => 'Enter description',
            'required' => false,
            'readonly' => false,
            ],
            [
            'id' => 'field-2-student-paymentFee',
            'label' => '',
            'name' => 'student_id',
            'type' => 'hidden',
            'placeholder' => 'Select student',
            'required' => true,
            'value' =>"",
            'readonly' => false,
            ],
            [
            'id' => 'balance-label-paymentFee',
            'label' => 'Current Balance',
            'name' => 'balance',
            'type' => 'text',
            'placeholder' => 'Loading...',
            'required' => false,
            'readonly' => true,
            ],
            ]
            ])
            @include('components.centered-modal', [
            'modalTitle' => 'Add Process Fee for ',
            'modalId'=>'processFee-student-modal',
            'label'=>'processFee-student-modal-label',
            'formAction' => route('processingFeeStudents.store'),
            'formId' => 'processFee-form',
            'saveBtn' => 'Save Process Fee',
            'fields' => [
            [
            'id' => 'field-1-credit',
            'label' => 'Credit',
            'name' => 'credit',
            'type' => 'number',
            'placeholder' => 'Enter credit',
            'required' => true,
            'step' => '0.01',
            'readonly' => false,
            ],
            [
            'id' => 'field-3-description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'placeholder' => 'Enter description',
            'required' => false,
            'readonly' => false,
            ],
            [
            'id' => 'field-2-student-processFee',
            'label' => '',
            'name' => 'student_id',
            'type' => 'hidden',
            'placeholder' => 'Select student',
            'required' => true,
            'value' => "",
            'readonly' => false,
            ],
            [
            'id' => 'balance-label-processFee',
            'label' => 'Current Balance',
            'name' => 'balance',
            'type' => 'text',
            'placeholder' => 'Loading...',
            'required' => false,
            'readonly' => true,
            ],
            ]
            ])


        </div>



        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>


@endsection