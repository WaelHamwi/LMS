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
                        <h3 class="page-title">Attendance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Mark Attendance</h4>

                    @if($students->isEmpty())
                    <div class="alert alert-danger mt-4">
                        <p>There are no students to show.</p>
                    </div>
                    @else
                    <form action="{{ route('attendance.store') }}" method="POST" id="attendance-form">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student Name</th>
                                        <th>Academic Level</th>
                                        <th>Classroom</th>
                                        <th>Section</th>
                                        <th>Attendance Status</th>
                                        <th>Attendance Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->name }} {{ $student->parent->father_name }}</td>
                                        <td>{{ $student->academicLevel->name }}</td>
                                        <td>{{ $student->classroom->name }}</td>
                                        <td>{{ $student->section->name }}</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}][status]" id="present-{{ $student->id }}" value="present"
                                                    @if(optional($student->todayAttendance)->attendance_status === 1) checked @endif required>
                                                <label class="form-check-label" for="present-{{ $student->id }}">Present</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}][status]" id="absent-{{ $student->id }}" value="absent"
                                                    @if(optional($student->todayAttendance)->attendance_status === 0) checked @endif>
                                                <label class="form-check-label text-danger" for="absent-{{ $student->id }}">Absent</label>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                            $todayDate = now()->format('Y-m-d');
                                            $todayAttendance = $student->attendance->filter(function ($attendance) use ($todayDate) {
                                            return $attendance->attendance_date->format('Y-m-d') === $todayDate;
                                            });
                                            @endphp

                                            @if($todayAttendance->isNotEmpty())
                                            @foreach($todayAttendance as $attendance)
                                            <p>{{ $attendance->attendance_date->format('Y-m-d') }}</p>
                                            @endforeach
                                            @else
                                            <p>Attendance not taken</p>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">Save Attendance</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection