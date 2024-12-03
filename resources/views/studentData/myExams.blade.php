@extends('layouts.master')

@section('content')

<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Exams</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Exams</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Exams List</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Exam Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $index => $exam)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if (isset($marksData[$exam->id]['cheating_status']) && $marksData[$exam->id]['cheating_status'] == 'suspected')
                                            <span class="badge badge-danger">Cheating suspected!</span>
                                        @else
                                            @if ($exam->examDone)
                                                <div class="popover-list"></div>
                                                <button class="example-popover btn btn-primary"
                                                    type="button"
                                                    data-bs-toggle="popover"
                                                    data-bs-trigger="hover"
                                                    data-bs-placement="bottom"
                                                    data-container="body"
                                                    data-bs-content="Marks: 
                                                        {{ $marksData[$exam->id]['marks_obtained'] ?? 'N/A' }} 
                                                        out of
                                                        {{ $marksData[$exam->id]['total_marks'] ?? 'N/A' }}">
                                                    {{ $exam->name }}
                                                </button>
                                            @else
                                                {{ $exam->name }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $exam->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        @if ($exam->examDone)
                                            <div>
                                                <span class="badge badge-success">done</span>
                                            </div>
                                        @else
                                            <a href="{{ route('exams.showExam', $exam->id) }}" class="btn btn-sm bg-primary-light">
                                                <i class="feather-eye"></i> View
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection
