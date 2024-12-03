@extends('layouts.master')

@section('content')
<div class="main-wrapper">
    <div class="page-wrapper">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Student Attendance Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Student Report</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Filter Attendance Reports</h4>

                    <form method="GET" action="{{ route('teacher.getReport') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="student_id">Select Student:</label>
                                <select name="student_id" id="student_id" class="form-control">
                                    <option value="">All Students</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}" required>
                            </div>

                            <div class="col-md-3">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}" required min="{{ request('start_date') }}">
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary mt-4">Show Report</button>
                            </div>
                        </div>
                    </form>

                    @if(request()->has('student_id') || request()->has('start_date') || request()->has('end_date'))
                    @if($students->isEmpty())
                    <div class="alert alert-info mt-4">
                        No attendance records found for the selected criteria.
                    </div>
                    @else
                    <div class="mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Attendance Status</th>
                                    <th>Attendance Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>
                                        @foreach($student->attendance as $attendance)
                                        <p>
                                            {{ $attendance->attendance_date->format('Y-m-d') }}:
                                            {{ $attendance->attendance_status }}
                                            @if($attendance->attendance_status == 1)
                                            <span class="badge badge-success">Present</span>
                                            @else
                                            <span class="badge badge-danger">Absent</span>
                                            @endif
                                        </p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($student->attendance as $attendance)
                                        <p>{{ $attendance->attendance_date->format('Y-m-d') }}</p>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
