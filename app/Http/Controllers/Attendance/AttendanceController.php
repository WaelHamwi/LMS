<?php

namespace App\Http\Controllers\Attendance;

use App\Repositories\Attendance\AttendanceRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{

    protected $Attendance;

    public function __construct(AttendanceRepositoryInterface $Attendance)
    {
        $this->Attendance = $Attendance;
    }


    public function index()
    {
        return $this->Attendance->index();
    }


    public function getAttendanceBySections(Request $request)
    {
        return $this->Attendance->getAttendanceBySections($request);
    }
    public function store(Request $request)
    {
        return $this->Attendance->store($request);
    }


    public function show($id)
    {
        return $this->Attendance->show($id);
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id) {}


    public function destroy($id) {}
}
