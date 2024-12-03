@extends('layouts.master')

@section('content')

<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Students Completed Exam: {{ $exam->name }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('teacher.exam') }}">Exams</a></li>
                            <li class="breadcrumb-item active">Students Completed</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Students List</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Total Score</th>
                                <th>Cheating Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                            @php
                            // Fetch the total score using native SQL for each student
                            $totalScore = DB::table('student_question_marks')
                            ->where('student_id', $student->id)
                            ->where('exam_id', $exam->id)
                            ->sum('marks_obtained');
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td><span class="badge badge-info">{{ $totalScore }}</span></td>
                                <td>
                                    @if ($student->cheating_status)
                                    <span class="badge bg-danger">Cheated</span>
                                    @else
                                    <span class="badge bg-success">No Cheating</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection