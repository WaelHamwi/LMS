<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
          
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-tachometer-alt"></i> <span>Student dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ URL('/student/dashboard') }}"><i ></i> dashboard</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-th-large"></i> <span>Student Exams</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('student.exams') }}"><i class="fas fa-book"></i> Exams</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-user-circle"></i> <span> Profile</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                   

                        <li>
                            <a href="{{ route('students.show', auth('student')->user()->id) }}">
                                <i class="fas fa-user"></i> <span> Profile</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>