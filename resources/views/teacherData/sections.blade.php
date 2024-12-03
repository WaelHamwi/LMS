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
                        <h3 class="page-title">Teacher's Students</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Students</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Student Information</h4>

                    @if($sections->isEmpty())
                    <div class="alert alert-warning mt-3">
                        No sections assigned to you or no students in your sections.
                    </div>
                    @else
                    @php
                    $headers = [
                    'Section Name',
                    'Student ID',
                    'Student Name',
                    'Email',
                    'Classroom',
                    'Date of Birth',
                    'Gender',
                    'Academic Year'
                    ];
                    $modelName = 'Student';
                    $routeDestroy = 'students.destroy';

                    $rows = [];
                    foreach ($sections as $section) {
                        foreach ($section->students as $student) {
                            $rows[] = [
                                'id' => $student->id,
                                'data' => [
                                    $section->name,
                                    $student->id,
                                    $student->name,
                                    $student->email,
                                    $student->classroom ? $student->classroom->name : 'N/A',
                                    $student->date_of_birth ?? 'N/A',
                                    $student->gender ?? 'N/A',
                                    $student->academic_year ?? 'N/A',
                                ],
                            ];
                        }
                    }

                    $actionButtons = function ($row) {
                    return '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="' . route('students.show', $row['data'][1]) . '">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="' . route('fee_invoices.index') . '">
                                    <i class="fas fa-list"></i> View Fee Invoices
                                </a>
                            </li>
                        </ul>
                    </div>
                    ';
                    };
                    @endphp

                    @include('components.data-table', [
                    'title' => 'Students in Your Sections',
                    'description' => 'View the list of students assigned to your sections',
                    'headers' => $headers,
                    'rows' => $rows,
                    'modelName' => $modelName,
                    'routeDestroy' => $routeDestroy,
                    'actionButtons' => $actionButtons,
                    'bulkDelete' => 'students'
                    ])
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
