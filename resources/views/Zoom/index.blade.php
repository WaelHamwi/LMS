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
                        <h3 class="page-title">Online Sessions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Online Sessions</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Create a New Online Session</h4>
                    <div class="button-list">
                        <!-- Button for creating an integrated online session -->
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#integrated-session-modal">Create Integrated Session</button>

                        <!-- Button for creating an indirect online session -->
                        <button type="button" class="btn btn-info waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#indirect-session-modal">Create Indirect Session</button>
                    </div>

                    <!-- Integrated Session Modal -->
                    @include('components.modal', [
                    'modalId' => 'integrated-session-modal',
                    'modalTitle' => 'Create Integrated Online Session',
                    'formId' => 'integrated-session-form',
                    'formAction' => route('online_sessions.store'),
                    'fields' => [
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
                    'id' => 'field-4-topic',
                    'label' => 'Topic',
                    'name' => 'topic',
                    'type' => 'text',
                    'placeholder' => 'Enter session topic',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-5-start-time',
                    'label' => 'Start Time',
                    'name' => 'start_time',
                    'type' => 'datetime-local',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-6-duration',
                    'label' => 'Duration (Minutes)',
                    'name' => 'duration',
                    'type' => 'number',
                    'placeholder' => 'Enter duration in minutes',
                    'required' => true,
                    ],
                    ],
                    'saveBtn'=>'save-button-integrated-session'
                    ])

                    <!-- Indirect Session Modal -->
                    @include('components.modal', [
                    'modalId' => 'indirect-session-modal',
                    'modalTitle' => 'Create Indirect Online Session',
                    'formId' => 'indirect-session-form',
                    'formAction' => route('online_sessions.store_indirect_integration'),
                    'fields' => [
                    [
                    'id' => 'field-1-academic-level',
                    'label' => 'Academic Level',
                    'name' => 'academic_level_id',
                    'type' => 'select',
                    'options' => $academicLevels->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select academic level',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-2-classroom',
                    'label' => 'Classroom',
                    'name' => 'classroom_id',
                    'type' => 'select',
                    'options' => $classrooms->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select classroom',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-3-section',
                    'label' => 'Section',
                    'name' => 'section_id',
                    'type' => 'select',
                    'options' => $sections->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select section',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-4-topic',
                    'label' => 'Topic',
                    'name' => 'topic',
                    'type' => 'text',
                    'placeholder' => 'Enter session topic',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-5-start-time',
                    'label' => 'Start Time',
                    'name' => 'start_time',
                    'type' => 'datetime-local',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-6-meeting-id',
                    'label' => 'Meeting ID',
                    'name' => 'meeting_id',
                    'type' => 'text',
                    'placeholder' => 'Enter meeting ID (if available)',
                    'required' => false,
                    ],
                    [
                    'id' => 'field-7-password',
                    'label' => 'Password',
                    'name' => 'password',
                    'type' => 'text',
                    'placeholder' => 'Enter meeting password',
                    'required' => false,
                    ],
                    [
                    'id' => 'field-8-duration',
                    'label' => 'Duration (Minutes)',
                    'name' => 'duration',
                    'type' => 'number',
                    'placeholder' => 'Enter duration in minutes',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-9-start-url',
                    'label' => 'Start URL',
                    'name' => 'start_url',
                    'type' => 'text',
                    'placeholder' => 'Enter start URL',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-10-join-url',
                    'label' => 'Join URL',
                    'name' => 'join_url',
                    'type' => 'text',
                    'placeholder' => 'Enter join URL',
                    'required' => true,
                    ],
                    ],
                    'saveBtn'=>'save-button-indirect-session'
                    ])

                </div>
            </div>

            @php
            $headers = ['ID', 'Topic', 'Academic Level', 'Classroom', 'Section', 'Created By','join'];
            $modelName = 'Online Session';
            $routeDestroy = 'online_sessions.destroy';

            $rows = $online_sessions->map(function ($session) {
            return [
            'id' => $session->id,
            'data' => [
            $session->id,
            $session->topic,
            $session->academicLevel->name,
            $session->classroom->name,
            $session->section->name,
            $session->created_by,
            new \Illuminate\Support\HtmlString('<a href="#" onclick="window.open(\'' . $session->join_url . '\', \'_blank\')" class="btn btn-primary btn-sm">Join Session</a>'),
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {
            return '
            <form action="' . route('online_sessions.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    data-title="Delete Session"
                    data-body="Are you sure you want to delete this session?"
                    data-action="delete"
                    data-url="/online_sessions/' . $row['data'][0] . '">
                    Delete
                </button>
            </form>';
            };
            @endphp

            @include('components.data-table', [
            'title' => 'Online Sessions',
            'description' => 'Manage your online sessions',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => ''
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection