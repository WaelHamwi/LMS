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
                        <h3 class="page-title">Promotions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Promotions</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Add New Promotion</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#promote-modal" id="add-promote">ADD PROMOTION</button>
                    </div>

                    @include('components.modal', [
                    'modalId' => 'promote-modal',
                    'modalTitle' => 'Add New Promotion',
                    'formId' => 'promote-form',
                    'formAction' => route('promotions.store'),
                    'fields' => [
                   
                    [
                    'id' => 'field-7-student-academic-level',
                    'label' => 'Current Academic Level',
                    'name' => 'current_academic_level_id',
                    'type' => 'select',
                    'options' => $academicLevels->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select current academic level',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-8-student-classroom',
                    'label' => 'Current Classroom',
                    'name' => 'current_classroom_id',
                    'type' => 'select',
                    'options' => [],
                    'placeholder' => 'Select current classroom',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-9-student-section',
                    'label' => 'Current Section',
                    'name' => 'current_section_id',
                    'type' => 'select',
                    'options' => [],
                    'placeholder' => 'Select current section',
                    'required' => true,
                    ],
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
                    'id' => 'field-7-student-academic-level-new',
                    'label' => 'New Academic Level',
                    'name' => 'new_academic_level_id',
                    'type' => 'select',
                    'options' => $academicLevels->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select new academic level',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-8-student-classroom-new',
                    'label' => 'New Classroom',
                    'name' => 'new_classroom_id',
                    'type' => 'select',
                    'options' => [],
                    'placeholder' => 'Select new classroom',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-9-student-section-new',
                    'label' => 'New Section',
                    'name' => 'new_section_id',
                    'type' => 'select',
                    'options' => [],
                    'placeholder' => 'Select new section',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-8-old-academic-year',
                    'label' => 'Old Academic Year',
                    'name' => 'academic_year_id',
                    'type' => 'text',
                    'value' => '',
                    'required' => true,

                    ],

                    ],
                    'saveBtn' => 'save-button-promote'
                    ])

                </div>
            </div>


            @php
            $headers = ['ID','Name', 'Current Level', 'Current Classroom', 'Current Section', 'New Level', 'New Classroom', 'New Section', 'Old Year', 'New Year'];
            $modelName = 'Promote';
            $routeDestroy = 'promotes.destroy';
            $rows = $promotedStudents->map(function ($promote) {
            return [
            'id' => $promote->id,
            'data' => [
                $promote->id,
            $promote->student->name ?? 'Not available',  
            $promote->currentAcademicLevel->name ?? 'N/A',
            $promote->currentClassroom->name ?? 'N/A',
            $promote->currentSection->name ?? 'N/A',
            $promote->newAcademicLevel->name ?? 'N/A',
            $promote->newClassroom->name ?? 'N/A',
            $promote->newSection->name ?? 'N/A',
            $promote->old_academic_year_id,
            $promote->new_academic_year_id,
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {
            return '


            <form action="' . route('promotions.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    data-title="Delete Promotion"
                    data-body="Are you sure you want to delete this promotion?"
                    data-action="delete"
                    data-url="/promotions/' . $row['data'][0] . '">
                    Delete
                </button>
            </form>
            ';
            };
            @endphp

            @include('components.data-table', [
            'title' => 'Promotions',
            'description' => 'Manage student promotions',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => 'promotions'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection