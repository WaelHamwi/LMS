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
                        <h3 class="page-name">Exams</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Exams</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Exam</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-primary waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#exam-modal" id="add-exam">ADD EXAM</button>
                    </div>
                    @include('components.modal', [
                    'modalId' => 'exam-modal',
                    'modalTitle' => 'Add New Exam',
                    'formId' => 'exam-form',
                    'formAction' => route('exams.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-exam-name',
                    'label' => 'Exam Name',
                    'name' => 'name',
                    'type' => 'text',
                    'placeholder' => 'Enter exam name',
                    'required' => true,
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
                    'label' => 'Section Level',
                    'name' => 'section_id',
                    'type' => 'select',
                    'options' => $sections->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select section level',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-4-subject',
                    'label' => 'Subject',
                    'name' => 'subject_id',
                    'type' => 'select',
                    'options' => $subjects->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select subject',
                    'required' => true,
                    ],

                    ],
                    'saveBtn'=>'save-button-exam'
                    ])
                </div>
            </div>

            @php
            $headers = ['ID', 'Exam name', 'Academic Level', 'Classroom', 'Subject'];
            $modelName = 'Exam';
            $routeDestroy = 'exams.destroy';

            $rows = $exams->map(function ($exam) {
            return [
            'id' => $exam->id,
            'data' => [
            $exam->id,
            $exam->name,
            $exam->academicLevel->name,
            $exam->classroom->name,
            $exam->subject->name,
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {
            return '
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row['data'][0] . '" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['data'][0] . '">
                    <li>
                        <button class="dropdown-item edit-exam"
                            data-bs-toggle="modal"
                            data-bs-target="#exam-modal"
                            data-id="' . $row['data'][0] . '"
                            data-name="' . $row['data'][1] . '"
                            data-academic-level="' . $row['data'][2] . '"
                            data-classroom="' . $row['data'][3] . '"
                            data-subject="' . $row['data'][4] . '">
                            <i class="fas fa-edit me-2"></i> Edit
                        </button>
                    </li>
                    <li>
                        <form action="' . route('exams.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="dropdown-item text-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop"
                                data-name="Delete Exam"
                                data-body="Are you sure you want to delete this exam?"
                                data-action="delete"
                                data-url="' . route('exams.destroy', $row['data'][0]) . '">
                                <i class="fas fa-trash-alt me-2"></i> Delete
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            ';
            };

            @endphp

            @include('components.data-table', [
            'title' => 'Exams',
            'description' => 'Add a new exam to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete'=>'exams_list'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection