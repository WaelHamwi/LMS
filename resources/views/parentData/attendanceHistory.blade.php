@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Attendance History</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ URL('dashboard/parent') }}">Parent</a>
                            </li>
                            <li class="breadcrumb-item active">Attendance History</li>
                        </ul>
                    </div>

                    <!-- Attendance History Form -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Filter Attendance History</h4>
                            <form method="GET" action="{{ route('parent.getHistoryReportAttendance') }}">
                                <div class="form-group">
                                    <label for="student_id">Student</label>
                                    <select name="student_id" id="student_id" class="form-control">
                                        <option value="">Select a student</option>
                                        @foreach ($allStudents as $student)
                                        <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="attendance_date">Attendance Date</label>
                                    <input type="date" name="attendance_date" id="attendance_date" class="form-control" value="{{ request('attendance_date') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                    </div>

                    <!-- Attendance History Table -->
                    @if ($students->isEmpty())
                    <div class="alert alert-warning">
                        No attendance history found for the selected filters.
                    </div>
                    @else
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Attendance History</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Attendance Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                    @foreach ($student->attendance as $attendance)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $attendance->attendance_date }}</td>
                                        <td>{{ $attendance->attendance_status == 0 ? 'Absent' : 'Attended' }}</td>

                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

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