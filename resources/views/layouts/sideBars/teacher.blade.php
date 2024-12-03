<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-user-circle"></i> <span> Profile</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('teacher.profile') }}"><i class="fas fa-user"></i>
                                <span> Profile</span></a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fas fa-tachometer-alt"></i> <span>Teacher Dashboard</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('teacher.dashboard') }}">Dashboard</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="feather-grid"></i> <span> teacher list</span>
                        <span class="menu-arrow"></span></a>

                    <ul>
                        <li>
                            <a href="{{ route('teacher.students') }}">students</a>
                        </li>
                        <li>
                            <a href="{{ route('teacher.sections') }}">sections</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="feather-grid"></i> <span> report</span>
                        <span class="menu-arrow"></span></a>

                    <ul>
                        <li>
                            <a href="{{ route('teacher.report') }}"><i class="feather-list"></i> <span>Students report</span></a>
                        </li>
                        <li>
                            <a href="{{ route('teacher.reportHistory') }}"><i class="fas fa-history fa-lg"></i> <span>History Report</span></a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fas fa-book fa-lg"></i> <span> Exams</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('teacher.exam') }}"><i class="fas fa-clipboard-list fa-lg"></i> <span>my exam</span></a>
                        </li>

                    </ul>

                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-question-circle"></i> <span> Questions</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('teacher.questions') }}"><i class="fas fa-clipboard-list fa-lg"></i> <span>my questionss</span></a>
                        </li>
                    </ul>

                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-video"></i> <span> sessions</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('teacher.sessions') }}"><i class="fas fa-video"></i>
                                <span>Online sessions</span></a>
                        </li>
                    </ul>

                </li>



            </ul>

        </div>
    </div>
</div>