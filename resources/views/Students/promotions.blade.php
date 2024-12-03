@extends('layouts.master')

@section('content')
<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Bulk Promote Student</h3>
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

                    <form action="{{ route('promotions.store') }}" method="POST" class="p-3">
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
                            <div class="col-md-6">
                                <label for="field-7-student-academic-level-new" class="form-label">New Academic Level</label>
                                <select name="new_academic_level_id" id="field-7-student-academic-level-new" class="form-select" required>
                                    <option value="">-- Select New Academic Level --</option>
                                    @foreach($academicLevels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="field-8-student-classroom-new" class="form-label">New Classroom</label>
                                <select name="new_classroom_id" id="field-8-student-classroom-new" class="form-select" required>
                                    <option value="">-- Select New Classroom --</option>
                                    @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="field-9-student-section-new" class="form-label">New Section</label>
                                <select name="new_section_id" id="field-9-student-section-new" class="form-select" required>
                                    <option value="">-- Select New Section --</option>
                                    @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Disabled Students Field for Display Only -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="field-1-student-id" class="form-label">Students</label>
                                <select id="field-1-student-id" class="form-select">
                                    <option value="">-- Students will be displayed here --</option>
                                    @foreach($students as $student)
                                    <option style="pointer-events: none; background-color: #f8f9fa;">
                                        {{ $student->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-12 mb-4">
                            <label for="field-8-old-academic-year" class="form-label">Selected old Academic Year</label>
                            <select name="academic_year_id" id="field-8-old-academic-year" class="form-select" required>
                                <option value="">-- Select Academic Year --</option>
                                @for ($year = 1900; $year <= 2050; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Promotion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>