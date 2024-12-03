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
                        <h3 class="page-title">Subjects</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subjects</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Subject</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-primary waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#subject-modal" id="add-subject">ADD SUBJECT</button>
                    </div>
                    @include('components.modal', [
                    'modalId' => 'subject-modal',
                    'modalTitle' => 'Add New Subject',
                    'formId' => 'subject-form',
                    'formAction' => route('subjects.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-subject',
                    'label' => 'Subject Name',
                    'name' => 'name',
                    'type' => 'text',
                    'placeholder' => 'Enter subject name',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-2-teacher',
                    'label' => 'teacher',
                    'name' => 'teacher_id',
                    'type' => 'select',
                    'options' => $teachers->pluck('first_name', 'id')->toArray(),
                    'placeholder' => 'Select teacher',
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

                    ],
                    'saveBtn'=>'save-button-subject'
                    ])
                </div>
            </div>

            @php

            $headers = ['ID', 'Subject Name', 'Academic Level', 'Classroom', 'teacher'];
            $modelName = 'Subject';
            $routeDestroy = 'subjects.destroy';

            $rows = $subjects->map(function ($subject) {
            return [
            'id' => $subject->id,
            'data' => [
            $subject->id,
            $subject->name,
            $subject->academicLevel->name,
            $subject->classroom->name,
            $subject->teacher->name,
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
                        <button class="dropdown-item edit-subject"
                            data-bs-toggle="modal"
                            data-bs-target="#subject-modal"
                            data-id="' . $row['data'][0] . '"
                            data-name="' . $row['data'][1] . '"
                            data-academic-level="' . $row['data'][2] . '"
                            data-classroom="' . $row['data'][3] . '"
                            data-section="' . $row['data'][4] . '">
                            <i class="fas fa-edit me-2"></i> Edit
                        </button>
                    </li>
                    <li>
                        <form action="' . route('subjects.destroy', $row['data'][0]) . '" method="POST">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="dropdown-item text-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop"
                                data-title="Delete Subject"
                                data-body="Are you sure you want to delete this subject?"
                                data-action="delete"
                                data-url="/subjects/' . $row['data'][0] . '">
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
            'title' => 'Subjects',
            'description' => 'Add a new subject to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete'=>'subjects_list'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection