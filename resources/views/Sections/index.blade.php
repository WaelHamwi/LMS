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
                        <h3 class="page-title">Sections</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sections</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Section</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-primary waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#section-modal" id="add-section">ADD SECTION</button>
                    </div>

                    @include('components.modal', [
                    'modalId' => 'section-modal',
                    'modalTitle' => 'Add New Section',
                    'formId' => 'section-form',
                    'formAction' => route('sections.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-section',
                    'label' => 'Section Name',
                    'name' => 'name',
                    'type' => 'text',
                    'placeholder' => 'Enter section name',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-2-academic-level',
                    'label' => 'Academic Level',
                    'name' => 'academic_level_id',
                    'type' => 'select',
                    'options' => $academicLevels->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select academic level',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-3-classroom',
                    'label' => 'Classroom',
                    'name' => 'classroom_id',
                    'type' => 'select',
                    'options' => $classrooms->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select classroom',
                    'required' => true,
                    ],

                    [
                    'id' => 'field-4-status',
                    'label' => 'Status',
                    'name' => 'status',
                    'type' => 'select',
                    'options' => [
                    1 => 'Active',
                    0 => 'Inactive'
                    ],
                    'placeholder' => 'Select status',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-5-teachers',
                    'label' => 'Teachers',
                    'name' => 'teacher_ids[]',
                    'type' => 'select',
                    'options' => $teachers->pluck('first_name', 'id')->toArray(),
                    'placeholder' => 'Select teachers',
                    'required' => false,
                    'multiple' => true,
                    'help_text' => 'Hold down the Ctrl (Windows) or Command (Mac) button to select multiple options.',
                    ],
                    ],
                    'saveBtn' => 'save-button-section'
                    ])
                </div>
            </div>

            @php
            $headers = ['ID', 'Name', 'Academic Level', 'Classroom', 'Status','Teacher'];
            $modelName = 'Section';
            $routeDestroy = 'sections.destroy';
            $rows = $sections->map(function ($section) {
            $teacherIds = $section->teachers->pluck('id')->toArray();

            return [
            'id' => $section->id,
            'data' => [
            $section->id,
            $section->name,
            $section->academicLevel->name,
            $section->classroom->name,
            $section->status ? 'Active' : 'Inactive',
            $section->teachers->pluck('first_name')->implode(', '),
            ],
            'teacher_ids' => $teacherIds,
            ];
            })->toArray();

            $actionButtons = function ($row) {
            $teacherIdsJson = json_encode($row['teacher_ids']);

            // dd($firstTeacherId);
            return '
            <button class="btn btn-rounded btn-warning edit-section"
                data-bs-toggle="modal"
                data-bs-target="#section-modal"
                data-id="' . $row['data'][0] . '"
                data-name="' . $row['data'][1] . '"
                data-academic-level="' . $row['data'][2] . '"
                data-classroom="' . $row['data'][3] . '"
                data-status="' . ($row['data'][4] == 'Active' ? 1 : 0) . '"
                data-teacher-ids="' . $teacherIdsJson . '">
                Edit
            </button>

            <form action="' . route('sections.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    data-title="Delete Section"
                    data-body="Are you sure you want to delete this section?"
                    data-action="delete"
                    data-url="/sections/' . $row['data'][0] . '">
                    Delete
                </button>
            </form>
            ';
            };
            @endphp

            @include('components.data-table', [
            'title' => 'Sections',
            'description' => 'Add a new section to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => 'sections'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection