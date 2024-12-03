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
                        <h3 class="page-title">Classrooms</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Classrooms</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Classroom</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-primary waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#classroom-modal" id="add-classroom">ADD CLASSROOM</button>
                    </div>

                    @include('components.modal', [
                    'modalId' => 'classroom-modal',
                    'modalTitle' => 'Add New Classroom',
                    'formId' => 'classroom-form',
                    'formAction' => route('classrooms.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-classroom',
                    'label' => 'Name',
                    'name' => 'name',
                    'type' => 'text',
                    'placeholder' => 'Enter classroom name',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-2-classroom',
                    'label' => 'Academic Level',
                    'name' => 'academic_level_id',
                    'type' => 'select',
                    'options' => $academicLevels->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select academic level',
                    'required' => true,
                    ],
                    ],
                    'saveBtn'=>'save-button-classroom'
                    ])
                </div>
            </div>

            @php

            $headers = ['ID', 'Name', 'Academic Level'];
            $modelName = 'Classroom';
            $routeDestroy = 'classrooms.destroy';

            $rows = $classrooms->map(function ($classroom) {
            return [
            'id' => $classroom->id,
            'data' => [
            $classroom->id,
            $classroom->name,
            $classroom->academicLevel->name,
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
                        <button class="dropdown-item edit-classroom"
                            data-bs-toggle="modal"
                            data-bs-target="#classroom-modal"
                            data-id="' . $row['data'][0] . '"
                            data-name="' . $row['data'][1] . '"
                            data-academic-level="' . $row['data'][2] . '">
                            <i class="fas fa-edit me-2"></i> Edit
                        </button>
                    </li>
                    <li>
                        <form action="' . route('classrooms.destroy', $row['data'][0]) . '" method="POST" style="display: inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                data-title="Delete Classroom"
                                data-body="Are you sure you want to delete this classroom?"
                                data-action="delete"
                                data-url="/classrooms/' . $row['data'][0] . '">
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
            'title' => 'Classrooms',
            'description' => 'Add a new classroom to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete'=>'classrooms'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection