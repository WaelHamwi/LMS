@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Student Results</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ URL('/parent/dashboard') }}">Parent</a>
                            </li>
                            <li class="breadcrumb-item active">Student Results</li>
                        </ul>
                    </div>

                    <!-- Table of Results -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Student Marks</h4>
                            @if ($studentResults->isEmpty())
                                <p>No results found for this parent.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Exam Name</th>
                                            <th>Question ID</th>
                                            <th>Marks Obtained</th>
                                            <th>Total Marks</th>
                                            <th>Cheating Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentResults as $result)
                                            <tr>
                                                <td>{{ $result->student_name }}</td>
                                                <td>{{ $result->exam_name }}</td>
                                                <td>{{ $result->question_id }}</td>
                                                <td>{{ $result->marks_obtained }}</td>
                                                <td>{{ $result->total_marks }}</td>
                                                <td>{{ $result->cheating_status ? 'Cheating Detected' : 'No Cheating' }}</td>
                                                <td>{{ $result->created_at }}</td>
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
    </div>

    <footer>
        <p>Copyright © 2022 Dreamguys.</p>
    </footer>
</div>

@endsection
