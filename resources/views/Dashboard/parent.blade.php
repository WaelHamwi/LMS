@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Welcome {{ auth()->user()->father_name }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Parent</li>
                        </ul>
                    </div>
                    @if($students->isNotEmpty())
                    <div class="row">
                        @foreach ($students as $student)
                        <div class="col-12 col-md-6 col-lg-4 d-flex">
                            <div class="card flex-fill bg-white" onclick="window.location.href='{{ route('parent.student.results', $student->id) }}'">
                                <div class="card-header text-center">
                                    <h5 class="card-title">{{ $student->name }}</h5>
                                </div>
                                <div class="card-body text-center">
                                    @php
                                    $image = $student->images->first();
                                    $imagePath = $image ? asset('attachments/students/' . $student->name . '/' . $image->filename) : null;
                                    @endphp

                                    @if ($imagePath)
                                    <img
                                        src="{{ $imagePath }}"
                                        alt="Image of {{ $student->name }}"
                                        class="img-fluid rounded mb-3"
                                        style="max-height: 200px; max-width: 100%;">
                                    @else
                                    <p class="text-muted">No image available for this student.</p>
                                    @endif

                                    <p><strong>Name:</strong> {{ $student->name }}</p>
                                    <p><strong>Email:</strong> {{ $student->email }}</p>
                                    <p><strong>Blood Type:</strong> {{ $student->blood }}</p>
                                    <p><strong>Email:</strong> {{ $student->email }}</p>
                                    <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                                    <p><strong>Nationality:</strong> {{ $student->nationality }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <!-- Alert for No Students -->
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <p>No students found!</p>
                        </div>
                    </div>
                    @endif
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