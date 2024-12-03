<div class="row">
    @php
    use Illuminate\Support\Facades\DB;

    $students_count = DB::select("SELECT COUNT(*) as count FROM students")[0]->count;
    $awards_count = DB::select("SELECT COUNT(*) as count FROM academic_levels")[0]->count;
    $classrooms_count = DB::select("SELECT COUNT(*) as count FROM classrooms")[0]->count;
    $teachers_count = DB::select("SELECT COUNT(*) as count FROM teachers")[0]->count;
    $sections_count = DB::select("SELECT COUNT(*) as count FROM sections")[0]->count;
    $revenue = DB::select("SELECT SUM(debit) - SUM(credit) AS total_revenue FROM fund_accounts");
    $totalRevenue = $revenue[0]->total_revenue ?? 0;
    @endphp
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Students</h6>
                        <h3>{{ $students_count }}</h3>
                    </div>
                    <div class="db-icon">
                        <img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div
                    class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Awards</h6>
                        <h3>50+</h3>
                    </div>
                    <div class="db-icon">
                        <img
                            src="assets/img/icons/dash-icon-02.svg"
                            alt="Dashboard Icon" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Sections</h6>
                        <h3>{{ $sections_count }}</h3>
                    </div>
                    <div class="db-icon">
                        <img src="assets/img/icons/dash-icon-03.svg" alt="Dashboard Icon" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div
                    class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Revenue</h6>
                        <h3>{{ $totalRevenue }}</h3>
                    </div>
                    <div class="db-icon">
                        <img
                            src="assets/img/icons/dash-icon-04.svg"
                            alt="Dashboard Icon" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>