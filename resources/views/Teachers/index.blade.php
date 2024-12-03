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
                        <h3 class="page-title">Teachers</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Teachers</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Teacher</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#teacher-modal" id="add-teacher">ADD TEACHER</button>
                    </div>

                    @include('components.modal', [
                    'modalId' => 'teacher-modal',
                    'modalTitle' => 'Add New Teacher',
                    'formId' => 'teacher-form',
                    'formAction' => route('teachers.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-first-name',
                    'label' => 'First Name',
                    'name' => 'first_name',
                    'type' => 'text',
                    'placeholder' => 'Enter first name',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-2-last-name',
                    'label' => 'Last Name',
                    'name' => 'last_name',
                    'type' => 'text',
                    'placeholder' => 'Enter last name',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-3-email',
                    'label' => 'Email',
                    'name' => 'email',
                    'type' => 'email',
                    'placeholder' => 'Enter email',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-4-password',
                    'label' => 'Password',
                    'name' => 'password',
                    'type' => 'password',
                    'placeholder' => 'Enter password',
                    'required' => false,
                    ],
                    [
                    'id' => 'field-5-address',
                    'label' => 'Address',
                    'name' => 'address',
                    'type' => 'text',
                    'placeholder' => 'Enter address',
                    'required' => false,
                    ],
                    [
                    'id' => 'field-6-gender',
                    'label' => 'Gender',
                    'name' => 'gender_id',
                    'type' => 'select',
                    'options' => $genders->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select gender',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-7-specialization',
                    'label' => 'Specialization',
                    'name' => 'specialization_id',
                    'type' => 'select',
                    'options' => $specializations->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select specialization',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-8-join-date',
                    'label' => 'Join Date',
                    'name' => 'join_date',
                    'type' => 'date',
                    'required' => true,
                    ],

                    ],
                    'saveBtn' => 'save-button-teacher'
                    ])
                </div>
            </div>

            @php
            $headers = ['ID', 'First Name', 'Last Name', 'Email', 'Gender', 'Specialization', 'Join Date'];
            $modelName = 'Teacher';
            $routeDestroy = 'teachers.destroy';

            $rows = $teachers->map(function ($teacher) {
            return [
            'id' => $teacher->id,
            'data' => [
            $teacher->id,
            $teacher->first_name,
            $teacher->last_name,
            $teacher->email,
            $teacher->gender->name,
            $teacher->specialization->name,
            $teacher->join_date->format('Y-m-d'),
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
                <button class="dropdown-item edit-teacher"
                    data-bs-toggle="modal"
                    data-bs-target="#teacher-modal"
                    data-id="' . $row['data'][0] . '"
                    data-first-name="' . $row['data'][1] . '"
                    data-last-name="' . $row['data'][2] . '"
                    data-email="' . $row['data'][3] . '"
                    data-gender="' . $row['data'][4] . '"
                    data-specialization="' . $row['data'][5] . '"
                    data-join-date="' . $row['data'][6] . '">
                    <i class="fas fa-edit me-2"></i> Edit
                </button>
            </li>
            <li>
                <form action="' . route('teachers.destroy', $row['data'][0]) . '" method="POST">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="button" class="dropdown-item text-danger" 
                        data-bs-toggle="modal" 
                        data-bs-target="#staticBackdrop"
                        data-title="Delete Teacher"
                        data-body="Are you sure you want to delete this teacher?"
                        data-action="delete"
                        data-url="/teachers/' . $row['data'][0] . '">
                        <i class="fas fa-trash-alt me-2"></i> Delete
                    </button>
                </form>
            </li>
        </ul>
    </div>
    ';
};
[]
            @endphp

            @include('components.data-table', [
            'title' => 'Teachers',
            'description' => 'Add a new teacher to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => 'teachers'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection