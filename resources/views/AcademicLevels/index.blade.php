@extends('layouts.master')

@section('content')

<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">
            {{-- Error messages --}}
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

            {{-- Page header --}}
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Data Tables</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Tables</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- Add new academic level card --}}
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Academic Level</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-primary waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#academic-level-modal" id="add-academic-level">ADD ACADEMIC LEVEL</button>
                    </div>

                    {{-- Add academic level modal --}}
                    @include('components.modal', [
                    'modalId' => 'academic-level-modal',
                    'modalTitle' => 'Add New Academic Level',
                    'formId' => 'academic-level-form',
                    'formAction' => route('academic_levels.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-academic-level',
                    'label' => 'Name',
                    'name' => 'name',
                    'type' => 'text',
                    'placeholder' => 'Enter academic level name',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-2-academic-level',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'text',
                    'placeholder' => 'Enter description',
                    'required' => true,
                    ],
                    ],
                    'saveBtn'=>'save-button-academic-level'
                    ])
                </div>

            </div>
            @php

            $headers = ['ID', 'Name', 'Description'];
            $modelName = 'Academic Level';
            $routeDestroy = 'academic_levels.destroy';

            $rows = $academicLevels->map(function ($academicLevel) {
            return [
            'id' => $academicLevel->id,
            'data' => [
            $academicLevel->id,
            $academicLevel->name,
            $academicLevel->description,
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
                        <button class="dropdown-item edit-academic-level"
                            data-bs-toggle="modal"
                            data-bs-target="#academic-level-modal"
                            data-id="' . $row['data'][0] . '"
                            data-name="' . $row['data'][1] . '"
                            data-description="' . $row['data'][2] . '">
                            <i class="fas fa-edit me-2"></i> Edit
                        </button>
                    </li>
                    <li>
                        <form action="' . route('academic_levels.destroy', $row['data'][0]) . '" method="POST" style="display: inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                data-title="Delete Academic Level"
                                data-body="Are you sure you want to delete this academic level?"
                                data-action="delete"
                                data-url="/academic_levels/' . $row['data'][0] . '">
                                <i class="fas fa-trash-alt me-2"></i> Delete
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            ';
            };



            @endphp

            {{-- Data table component --}}
            @include('components.data-table', [
            'title' => 'Academic Levels',
            'description' => 'Add a new academic level to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete'=>'academic_levels'
            ])

        </div>

        {{-- Footer --}}
        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection