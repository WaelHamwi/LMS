<?php


namespace App\Repositories\Attendance;

use Illuminate\Http\Request;

interface AttendanceRepositoryInterface
{
    public function index();
    public function getAttendanceBySections(Request $request);
    public function show($id);

    public function store(Request $request);

    public function update($request);

    public function destroy($request);
}
