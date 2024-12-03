@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Student Dashboard - {{ $student->name }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ URL('dashboard/parent') }}">Parent</a>
                            </li>
                            <li class="breadcrumb-item active">Student Dashboard</li>
                        </ul>
                    </div>

                    <!-- Table of Marks -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Student Marks</h4>
                            <div class="table-responsive">
                                <table class="datatable table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Question ID</th>
                                            <th>Marks Obtained</th>
                                            <th>Total Marks</th>
                                            <th>Cheating Status</th>
                                            <th>Exam ID</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($marks->isEmpty())
                                        <tr>
                                            <td colspan="6" class="bg-danger text-center">There is no data to show</td>
                                        </tr>
                                        @else
                                        @foreach ($marks as $mark)
                                        <tr>
                                            <td>{{ $mark->question_id }}</td>
                                            <td>{{ $mark->marks_obtained }}</td>
                                            <td>{{ $mark->total_marks }}</td>
                                            <td>{{ $mark->cheating_status ? 'Cheating Detected' : 'No Cheating' }}</td>
                                            <td>{{ $mark->exam_name ?? 'N/A' }}</td>
                                            <td>{{ $mark->created_at }}</td>
                                        </tr>
                                        @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
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