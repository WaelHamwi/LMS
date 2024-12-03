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
                        <h3 class="page-title">Student Graduation Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Graduation Index</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Manage Student Graduation Information</h4>
                    <p class="text-muted">This page allows you to view and manage graduation information for students, including their current academic levels, classrooms, and sections.</p>
                    <div class="button-list">
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#graduate-modal" id="add-graduate">ADD one GRADUATE</button>
                    </div>

                    @include('components.modal', [
                    'modalId' => 'graduate-modal',
                    'modalTitle' => 'Add New Graduate',
                    'formId' => 'graduate-form',
                    'formAction' => route('graduations.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-student-id',
                    'label' => 'Student ID',
                    'name' => 'student_id',
                    'type' => 'select',
                    'options' => $students->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select student',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-7-student-academic-level',
                    'label' => ' Academic Level',
                    'name' => 'academic_level_id',
                    'type' => 'select',
                    'options' => $academicLevels->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select academic level',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-8-student-classroom',
                    'label' => ' Classroom',
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
                    ],
                    'saveBtn' => 'save-button-graduate'
                    ])

                </div>
            </div>

            @php
            $headers = ['ID', 'Student Name', 'Academic Level', 'Classroom', 'Section', 'Graduation Year'];
            $modelName = 'Graduate';
            $routeDestroy = 'graduations.destroy';
            $rows = $graduatedStudents->map(function ($student) {
            return [
            'id' => $student->id,
            'data' => [
            $student->id,
            $student->name,
            $student->academic_level_id,
            $student->classroom_id,
            $student->section_id,
            $student->deleted_at,
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {
            return '
            <button class="btn btn-rounded btn-warning edit-graduation"
                data-bs-toggle="modal"
                data-bs-target="#warning-alert-modal"
                data-id="' . $row['data'][0] . '"
                data-name="' . $row['data'][1] . '"
                data-academic-level="' . $row['data'][2] . '"
                data-classroom="' . $row['data'][3] . '"
                data-section="' . $row['data'][4] . '">
                Undo
            </button>

            <form action="' . route('graduations.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    data-title="Delete Graduate Record"
                    data-body="Are you sure you want to delete this graduate record?"
                    data-action="delete"
                    data-url="/graduations/' . $row['data'][0] . '">
                    Delete
                </button>
            </form>
            ';
            };

            @endphp

            @include('components.warning-alert', [
            'title' => 'Graduation Undo',
            'message' => 'Are you sure you want to undo the graduation for this student?'
            ])

            @include('components.data-table', [
            'title' => 'graduation',
            'description' => 'View and manage the graduation information of students.',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => 'graduations'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection