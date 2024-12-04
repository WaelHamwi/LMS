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
                    @if ($students->isEmpty())
                    <div class="alert alert-info">
                        No students have completed this exam yet.
                    </div>
                    @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Total Score</th>
                                <th>Cheating Status</th>
                                <th>Action</th>
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
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#remakeExamModal-{{ $student->id }}">
                                        Remake Exam
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="remakeExamModal-{{ $student->id }}" tabindex="-1" aria-labelledby="remakeExamModalLabel-{{ $student->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="remakeExamModalLabel-{{ $student->id }}">Confirm Remake Exam</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to reset the exam for <strong>{{ $student->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('teacherExams.remakeExamForStudent', ['exam' => $exam->id, 'studentId' => $student->id]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning">Confirm</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
