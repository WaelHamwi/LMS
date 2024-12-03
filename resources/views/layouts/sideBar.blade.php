<div class="sidebar">

    @if(Auth::guard('student')->check())
    @include('layouts.sideBars.student') <!-- Sidebar for student -->
    @elseif(Auth::guard('teacher')->check())
    @include('layouts.sideBars.teacher') <!-- Sidebar for teacher -->
    @elseif(Auth::guard('parent')->check())
    @include('layouts.sideBars.parent') <!-- Sidebar for parent -->
    @else
    @include('layouts.sideBars.admin') <!-- Default sidebar or for guest users -->
    @endif
</div>

<