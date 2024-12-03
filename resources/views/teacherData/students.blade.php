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
                        <h3 class="page-title">Teacher's Students</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Students</li>
                        </ul>
                    </div>
                </div>
            </div>

            <form action="{{ route('teacher.attendance.store') }}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Student Attendance</h4>

                        @if($students->isEmpty())
                        <div class="alert alert-warning mt-3">
                            No students assigned to you.
                        </div>
                        @else
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Section</th>
                                    <th>Classroom</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>Academic Year</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->section ? $student->section->name : 'N/A' }}</td>
                                    <td>{{ $student->classroom ? $student->classroom->name : 'N/A' }}</td>
                                    <td>{{ $student->date_of_birth ?? 'N/A' }}</td>
                                    <td>{{ $student->gender ?? 'N/A' }}</td>
                                    <td>{{ $student->academic_year ?? 'N/A' }}</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="attendance[{{ $student->id }}][status]" 
                                                id="present-{{ $student->id }}" 
                                                value="present" 
                                                @if(optional($student->todayAttendance)->attendance_status === 1) checked @endif>
                                            <label class="form-check-label" for="present-{{ $student->id }}">Present</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="attendance[{{ $student->id }}][status]" 
                                                id="absent-{{ $student->id }}" 
                                                value="absent" 
                                                @if(optional($student->todayAttendance)->attendance_status === 0) checked @endif>
                                            <label class="form-check-label text-danger" for="absent-{{ $student->id }}">Absent</label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary mt-3">Submit Attendance</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
