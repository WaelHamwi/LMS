@extends('layouts.master')

@section('content')
<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Bulk Student Graduation</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('graduations.store', ['bulk' => 1]) }}" method="POST" class="p-3">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="field-7-student-academic-level" class="form-label">Current Academic Level</label>
                                <select name="current_academic_level_id" id="field-7-student-academic-level" class="form-select" required>
                                    <option value="">-- Select Current Academic Level --</option>
                                    @foreach($academicLevels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="field-8-student-classroom" class="form-label">Current Classroom</label>
                                <select name="current_classroom_id" id="field-8-student-classroom" class="form-select" required>
                                    <option value="">-- Select Current Classroom --</option>
                                    @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="field-9-student-section" class="form-label">Current Section</label>
                                <select name="current_section_id" id="field-9-student-section" class="form-select" required>
                                    <option value="">-- Select Current Section --</option>
                                    @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Graduations</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection