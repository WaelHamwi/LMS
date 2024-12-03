<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-user-circle"></i> <span>parent profile</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ Route('parent.profile') }}"><i class="fas fa-user"></i> profile</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-tachometer-alt"></i> <span>parent dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ URL('/parent/dashboard') }}"><i class="fas fa-user"></i> profile</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"> <i class="fas fa-graduation-cap"></i> <span>child results</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('parent.students.results', ['parentId' => auth()->user()->id]) }}">
                                <i class="fas fa-list"></i> View Results
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-user-check"></i> <span>Attendance</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('parent.historyReportAttendance') }}">
                                <i class="fas fa-user-check"></i> View Results
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span>Fee Invoices</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('parent.feeInvoices') }}">
                                <i class="fas fa-file-invoice"></i> View Fee Invoices
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>