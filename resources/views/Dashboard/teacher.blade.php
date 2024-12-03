@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Welcome teacher!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active">teacher</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                @php
                use Illuminate\Support\Facades\DB;

                $teacher_id = auth()->user()->id;

                $sections_count = DB::table('teacher_section')
                ->where('teacher_id', $teacher_id)
                ->count();


                $students_count = DB::table('students')
                ->join('teacher_section', 'students.section_id', '=', 'teacher_section.section_id')
                ->where('teacher_section.teacher_id', $teacher_id)
                ->count();

                $academic_levels = DB::table('academic_levels')->count();
                $classrooms_count = DB::table('classrooms')->count();
                $teachers_count = DB::table('teachers')->count();

                @endphp

                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                    <a href="{{ route('teacher.students') }}" class="w-100">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Students</h6>
                                        <h3>{{ $students_count }}</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="{{ asset('assets/img/icons/dash-icon-01.svg') }}" alt="Dashboard Icon" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <a href="{{ route('teacher.sections') }}" class="w-100">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Sections</h6>
                                    <h3>{{ $sections_count }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ asset('assets/img/icons/dash-icon-03.svg') }}" alt="Dashboard Icon" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @livewire('calendar.calendar')
    </div>


    <footer>
        <p>Copyright © 2022 Dreamguys.</p>
    </footer>
</div>
@endsection