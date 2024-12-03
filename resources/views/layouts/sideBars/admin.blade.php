<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-tachometer-alt"></i> <span>Admin Dashboard</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="feather-grid"></i> <span> Academic levels</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('academic_levels.index') }}">Levels</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-graduation-cap"></i> <span> classrooms</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('classrooms.index') }}">classrooms</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="{{ route('sections.index') }}" href="javascript:void(0);"><i class="fas fa-code"></i> <span>Sections</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);" id="load-classrooms" data-url="{{ route('classrooms.byAcademicLevel') }}">
                                <span>Classrooms' sections</span> <span class="menu-arrow"></span>
                            </a>
                            <ul id="classrooms-list">

                            </ul>
                        </li>


                        <li>
                            <a href="{{ route('sections.index') }}" href="javascript:void(0);"> <span>All sections</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-graduation-cap"></i> <span> Parents</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                      
                        <li><a href="{{ route('add_parent') }}">Parents List</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-graduation-cap"></i> <span> Students</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('students.index') }}">Student List</a></li>
                        <li><a href="{{ route('promotions.list') }}">Student promote list</a></li>
                        <li><a href="{{ route('promotions.index') }}">Students Promotion</a></li>
                        <li><a href="{{ route('graduations.index', ['bulk' => 1]) }}">Students Bulk Graduation</a></li>
                        <li><a href="{{ route('graduations.index') }}">Students Graduation List</a></li>
                        <li><a href="{{ route('fees.index') }}">Students's fees List</a></li>
                        <li><a href="{{ route('receiptStudents.index') }}">Students's receipts</a></li>
                        <li><a href="{{ route('paymentFeeStudents.index') }}">Students's payment Fees</a></li>
                        <li><a href="{{ route('processingFeeStudents.index') }}">Students's process Fees</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span> Teachers</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('teachers.index') }}">Teacher List</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-book-reader"></i> <span> Subjects</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('subjects.index') }}">Subject List</a></li>
                    </ul>
                </li>
             
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fas fa-user-check"></i> <span>Attendance</span>
                        <span class="menu-arrow"></span> </a>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);" id="load-attendance-sections" data-url="{{ route('attendance.bySections') }}">
                                <span>Sections Attendance</span> <span class="menu-arrow"></span>
                            </a>
                            <ul id="attendance-sections-list">
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('attendance.index') }}"> <span>All attendances</span></a>
                        </li>
                    </ul>

                </li>



                <li class="menu-title">
                    <span>Management</span>
                </li>

                <li>
                    <a href="{{ route('exams.index') }}"><i class="fas fa-clipboard-list"></i>
                        <span>Exam list</span></a>
                </li>
                <li>
                    <a href="{{ route('online_sessions.index') }}"><i class="fas fa-video"></i>
                        <span>Online sessions</span></a>
                </li>
                <li>
                    <a href="{{ route('questions.index') }}"><i class="fas fa-question-circle"></i>
                        <span>Question list</span></a>
                </li>
                <li>
                    <a href="{{ route('libraries.index') }}"><i class="fas fa-book"></i> <span>Library</span></a>
                </li>

                <li>
                    <a href="{{route('settings.index')}}"><i class="fas fa-cog"></i> <span>Settings</span></a>
                </li>


            </ul>
        </div>
    </div>
</div>