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
                        <h3 class="page-title">Library</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Library</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Book</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#book-modal" id="add-book">ADD BOOK</button>
                    </div>
                    @include('components.modal', [
                    'modalId' => 'book-modal',
                    'modalTitle' => 'Add New Book',
                    'formId' => 'book-form',
                    'formAction' => route('libraries.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-title',
                    'label' => 'Book Title',
                    'name' => 'title',
                    'type' => 'text',
                    'placeholder' => 'Enter book title',
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
                    'label' => 'section',
                    'name' => 'section_id',
                    'type' => 'select',
                    'options' => $sections->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select section',
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
                    'id' => 'field-5-file',
                    'label' => 'Book File',
                    'name' => 'file_name',
                    'type' => 'file',
                    'required' => false,
                    ],
                    ],
                    'saveBtn' => 'save-button-book'
                    ])
                </div>

            </div>

            @php
            $headers = ['ID', 'Book Title', 'Adacemiclevel', 'Classroom', 'Section', 'Teacher','file'];
            $modelName = 'Library Book';
            $routeDestroy = 'libraries.destroy';

            $rows = $books->map(function ($book) {
            return [
            'id' => $book->id,
            'data' => [
            $book->id,
            $book->title,
            $book->academicLevel->name,
            $book->classroom->name,
            $book->section->name,
            $book->teacher->first_name,
            $book->file_name,
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {



            $fileDownloadUrl = route('libraries.download', $row['data'][6]);

            return '
            <div class="btn-group">
                <button type="button" class="btn btn-rounded btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu">
                    <!-- Edit Button -->
                    <li>
                        <button class="dropdown-item edit-book"
                            data-bs-toggle="modal"
                            data-bs-target="#book-modal"
                            data-id="' . $row['data'][0] . '"
                            data-title="' . $row['data'][1] . '"
                            data-academiclevel="' . $row['data'][2] . '"
                            data-classroom="' . $row['data'][3] . '"
                            data-section="' . $row['data'][4] . '"
                            data-teacher="' . $row['data'][5] . '">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </li>

                    <!-- Download Button -->
                    <li>
                        <a class="dropdown-item" href="' . $fileDownloadUrl . '" download>
                            <i class="fas fa-download"></i> Download File
                        </a>
                    </li>

                    <!-- Delete Button -->
                    <li>
                        <form action="' . route('libraries.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                data-title="Delete Book"
                                data-body="Are you sure you want to delete this book?"
                                data-action="delete"
                                data-url="/libraries/' . $row['data'][0] . '">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            ';
            };
            @endphp

            @include('components.data-table', [
            'title' => 'Library Books',
            'description' => 'Add a new book to the library',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => 'libraries_list'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection