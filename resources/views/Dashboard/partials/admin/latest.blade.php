@php
$students = DB::select("SELECT id, name, date_of_birth, section_id, academic_year FROM students ORDER BY created_at DESC LIMIT 5");
$sections = DB::table('sections')
    ->join('classrooms', 'sections.classroom_id', '=', 'classrooms.id') 
    ->join('academic_levels', 'sections.academic_level_id', '=', 'academic_levels.id') 
    ->select('sections.id', 'sections.name as section_name', 'classrooms.name as classroom_name', 'academic_levels.name as academic_level_name')
    ->orderBy('sections.created_at', 'desc') 
    ->limit(5)
    ->get();

    $teachers = DB::table('teachers')
    ->join('specializations', 'teachers.specialization_id', '=', 'specializations.id')
    ->select('teachers.*', 'specializations.name as specialization_name')
    ->orderBy('teachers.created_at', 'desc') 
    ->limit(5)
    ->get();

@endphp

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">latest news</h4>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active show mb-1" id="v-pills-students-tab" data-bs-toggle="pill" href="#v-pills-students" role="tab" aria-controls="v-pills-students" aria-selected="true">
                                Students
                            </a>
                            <a class="nav-link mb-1" id="v-pills-sections-tab" data-bs-toggle="pill" href="#v-pills-sections" role="tab" aria-controls="v-pills-sections" aria-selected="false">
                                Sections
                            </a>
                            <a class="nav-link mb-1" id="v-pills-teachers-tab" data-bs-toggle="pill" href="#v-pills-teachers" role="tab" aria-controls="v-pills-teachers" aria-selected="false">
                                Teachers
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="tab-content">
                            <!-- Students Tab -->
                            <div class="tab-pane fade active show" id="v-pills-students" role="tabpanel" aria-labelledby="v-pills-students-tab">
                                <div class="card flex-fill student-space comman-shadow">
                                    <div class="card-header d-flex align-items-center">
                                        <h5 class="card-title">Students</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table star-student table-hover table-center table-borderless table-striped">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th class="text-center">Date of Birth</th>
                                                        <th class="text-center">Section ID</th>
                                                        <th class="text-end">Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($students as $student)
                                                    <tr>
                                                        <td>{{ $student->id }}</td>
                                                        <td>{{ $student->name }}</td>
                                                        <td class="text-center">{{ $student->date_of_birth }}</td>
                                                        <td class="text-center">{{ $student->section_id }}</td>
                                                        <td class="text-end">{{ $student->academic_year }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No data available</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sections Tab -->
                            <div class="tab-pane fade" id="v-pills-sections" role="tabpanel" aria-labelledby="v-pills-sections-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Sections</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-center table-borderless table-striped">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Classroom</th>
                                                        <th>Grade Level</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($sections as $section)
                                                    <tr>
                                                        <td>{{ $section->id }}</td>
                                                        <td>{{ $section->section_name }}</td>
                                                        <td>{{ $section->classroom_name }}</td>
                                                        <td>{{ $section->academic_level_name }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No data available</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Teachers Tab -->
                            <div class="tab-pane fade" id="v-pills-teachers" role="tabpanel" aria-labelledby="v-pills-teachers-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Teachers</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-center table-borderless table-striped">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Subject</th>
                                                        <th>Hire Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($teachers as $teacher)
                                                    <tr>
                                                        <td>{{ $teacher->id }}</td>
                                                        <td>{{ $teacher->first_name }}</td>
                                                        <td>{{ $teacher->specialization_name }}</td>
                                                        <td>{{ $teacher->join_date }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No data available</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Teachers Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>