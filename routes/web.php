<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ViolationTypeController;
use App\Http\Controllers\DisciplineActionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GradeMajorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RekapController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES — Tidak memerlukan autentikasi
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('pages.welcome'))->name('home');
Route::get('/lapor',             fn () => view('pages.user.report-page.report'))->name('lapor.index');
Route::get('/lacak',             fn () => view('pages.user.track-page.track'))->name('lapor.lacak');
Route::get('/progress-laporan',  fn () => view('pages.user.track-page.report-progress'))->name('lapor.progress');
Route::get('/contact',           fn () => view('pages.user.contact-page.contact'))->name('lapor.contact');

/*
|--------------------------------------------------------------------------
| PUBLIC API — Laporan & Siswa (digunakan oleh form publik)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {

    Route::post('/contact', [ContactController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('api.contact.store');

    Route::post('/reports',           [ReportController::class, 'store'])->middleware('throttle:30,1')->name('api.reports.store');
    Route::get('/reports/track',      [ReportController::class, 'track'])->name('api.reports.track');
    Route::post('/reports/feedback',  [ReportController::class, 'storeFeedback'])->middleware('throttle:3,1')->name('api.reports.feedback');
    Route::post('/reports/reminder',  [ReportController::class, 'sendReminder'])->middleware('throttle:3,1')->name('api.reports.reminder');
    Route::post('/reports/detail',    [ReportController::class, 'storeDetail'])->middleware('throttle:10,1')->name('api.reports.detail');

    Route::get('/students/search',       [ReportController::class, 'searchStudent'])->name('api.students.search');
    Route::get('/students/autocomplete', [ReportController::class, 'autocompleteStudent'])->name('api.students.autocomplete');

    Route::get('/violation-types/autocomplete', [ViolationTypeController::class, 'autocomplete'])->name('api.violation-types.autocomplete');

    Route::prefix('data-siswa')->group(function () {
        Route::get('/grades',       [GradeMajorController::class, 'gradesList'])->name('api.students.grades.public');
        Route::get('/majors',       [GradeMajorController::class, 'majorsList'])->name('students.api.majors.public');        // ← nama lama
        Route::get('/majors/full',  [GradeMajorController::class, 'majorsFullList'])->name('students.api.majors.full.public'); // ← nama lama
        Route::get('/grade-majors', [GradeMajorController::class, 'pairsList'])->name('api.grade.majors.pairs.public');
    });
});

/*
|--------------------------------------------------------------------------
| LOGIN PAGE
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('administrator.dashboard');
    }
    return view('pages.administrator.login-page.login');
})->name('administrator.login');

Route::post('/api/admin/login', [AuthController::class, 'login'])->name('api.admin.login');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES — Memerlukan autentikasi (auth:web)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:web')->group(function () {

    /*
    |----------------------------------------------------------------------
    | Auth & Notifikasi — Semua role bisa akses
    |----------------------------------------------------------------------
    */

    Route::prefix('api/admin')->group(function () {
        Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('api.admin.logout');
        Route::get('/me', [AuthController::class, 'me'])->name('api.admin.me');
    });

    Route::prefix('api/admin/notifications')->group(function () {
        Route::get('/',           [NotificationController::class, 'index']);
        Route::get('/count',      [NotificationController::class, 'count']);
        Route::post('/read-all',  [NotificationController::class, 'markAllRead']);
        Route::post('/{id}/read', [NotificationController::class, 'markRead']);
    });

    /*
    |----------------------------------------------------------------------
    | Dashboard — Semua role bisa akses
    |----------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('administrator.dashboard');
    Route::get('/admin/notifications', fn () => view('pages.administrator.notification-page.notifications'))->name('administrator.notifications');

    /*
    |----------------------------------------------------------------------
    | Manajemen Laporan — Butuh permission: view-laporan
    |----------------------------------------------------------------------
    */

    Route::middleware('permission:view-laporan')->group(function () {

        // Halaman laporan
        Route::get('/laporan-masuk',       fn () => view('pages.administrator.report-management-page.incoming-report'))->name('administrator.incoming-report');
        Route::get('/menunggu-verifikasi', fn () => view('pages.administrator.report-management-page.pending-verification'))->name('administrator.pending-verification');
        Route::get('/proses-laporan',      fn () => view('pages.administrator.report-management-page.processing-report'))->name('administrator.processing-report');
        Route::get('/laporan-selesai',     fn () => view('pages.administrator.report-management-page.report-closed'))->name('administrator.report-closed');
        Route::get('/laporan-ditolak',     fn () => view('pages.administrator.report-management-page.report-rejected'))->name('administrator.report-rejected');

        // API — Lihat laporan
        Route::prefix('api/admin')->group(function () {
            Route::get('/reports',        [ReportController::class, 'adminIndex']);
            Route::get('/reports/counts', [ReportController::class, 'reportCounts']);
            Route::get('/reports/{id}',   [ReportController::class, 'adminShow']);
            Route::get('/discipline-actions', [DisciplineActionController::class, 'list']);
        });
    });

    // API — Verifikasi laporan
    Route::middleware('permission:verify-laporan')->group(function () {
        Route::put('/api/admin/reports/{id}/status', [ReportController::class, 'updateStatus']);
    });

    // API — Proses laporan
    Route::middleware('permission:process-laporan')->group(function () {
        Route::prefix('api/admin')->group(function () {
            Route::post('/reports/{id}/persons',               [ReportController::class, 'storePerson']);
            Route::delete('/reports/{id}/persons/{personId}',  [ReportController::class, 'destroyPerson']);
            Route::post('/reports/{id}/follow-up',             [ReportController::class, 'storeFollowUp']);
            Route::put('/reports/{id}/follow-up/{followUpId}', [ReportController::class, 'updateFollowUp']);
            Route::post('/reports/{id}/reminder-to-reporter',  [ReportController::class, 'sendReminderToReporter'])->name('api.admin.reports.reminder-reporter');
        });
    });

    // API — Tolak laporan
    Route::middleware('permission:reject-laporan')->group(function () {
        // updateStatus sudah handle reject, tapi jika ada endpoint khusus tambahkan di sini
    });

    /*
    |----------------------------------------------------------------------
    | Rekapitulasi — Butuh permission: view-rekap
    |----------------------------------------------------------------------
    */

    Route::middleware('permission:view-rekap')->group(function () {
        Route::get('/rekapitulasi-PerBulan',    fn () => view('pages.administrator.case-recapitulation-page.monthly'))->name('administrator.monthly');
        Route::get('/rekapitulasi-PerSemester', fn () => view('pages.administrator.case-recapitulation-page.semester'))->name('administrator.semester');

        Route::prefix('api/admin/rekap')->group(function () {
            Route::get('/bulan',        [RekapController::class, 'bulan']);
            Route::get('/semester',     [RekapController::class, 'semester']);
            Route::get('/detail-kelas', [RekapController::class, 'detailKelas']);
        });
    });

    // Export — Butuh permission: export-data
    Route::middleware('permission:export-data')->group(function () {
        Route::prefix('api/admin/rekap')->group(function () {
            Route::get('/bulan/export',    [RekapController::class, 'exportBulan']);
            Route::get('/semester/export', [RekapController::class, 'exportSemester']);
            Route::get('/download-kelas',  [RekapController::class, 'downloadKelas']);
        });
    });

    /*
    |----------------------------------------------------------------------
    | Master Data — Butuh permission: manage-master-data
    |----------------------------------------------------------------------
    */

    Route::middleware('permission:manage-master-data')->group(function () {

        Route::prefix('SIP-Bullying')->group(function () {

            // Data Siswa
            Route::get('/data-siswa', [StudentController::class, 'index'])->name('administrator.students');

            Route::prefix('api/data-siswa')->group(function () {
                Route::get('/list',                       [StudentController::class, 'getStudents'])->name('students.api.list');
                Route::post('/save',                      [StudentController::class, 'store'])->name('students.api.save');
                Route::delete('/delete/{id}',             [StudentController::class, 'destroy'])->name('students.api.delete');

                Route::post('/majors/save',               [GradeMajorController::class, 'majorSave'])->name('students.api.majors.save');
                Route::delete('/majors/delete/{name}',    [GradeMajorController::class, 'majorDelete'])->name('students.api.majors.delete');

                Route::post('/grades/save',               [GradeMajorController::class, 'gradeSave'])->name('students.api.grades.save');
                Route::delete('/grades/delete/{grade}',   [GradeMajorController::class, 'gradeDelete'])->name('students.api.grades.delete');

                Route::get('/grade-majors',               [GradeMajorController::class, 'pairsList'])->name('api.grade.majors.pairs');
                Route::get('/grades-by-major/{major}',    [GradeMajorController::class, 'gradesByMajor'])->name('api.grades.by.major');
                Route::get('/major-by-grade/{grade}',     [GradeMajorController::class, 'majorByGrade'])->name('api.major.by.grade');
            });

            // Jenis Pelanggaran
            Route::get('/jenis-pelanggaran', [ViolationTypeController::class, 'index'])->name('administrator.violation-types');

            Route::prefix('api/jenis-pelanggaran')->group(function () {
                Route::get('/list',           [ViolationTypeController::class, 'list'])->name('violation-types.api.list');
                Route::post('/save',          [ViolationTypeController::class, 'store'])->name('violation-types.api.save');
                Route::delete('/delete/{id}', [ViolationTypeController::class, 'destroy'])->name('violation-types.api.delete');
            });

            // Tindakan Disiplin
            Route::get('/tindakan-disiplin', [DisciplineActionController::class, 'index'])->name('administrator.discipline-actions');

            Route::prefix('api/tindakan-disiplin')->group(function () {
                Route::get('/list',           [DisciplineActionController::class, 'list'])->name('discipline-actions.api.list');
                Route::post('/save',          [DisciplineActionController::class, 'store'])->name('discipline-actions.api.save');
                Route::delete('/delete/{id}', [DisciplineActionController::class, 'destroy'])->name('discipline-actions.api.delete');
            });
        });
    });

    /*
    |----------------------------------------------------------------------
    | User Management — Butuh permission masing-masing
    |----------------------------------------------------------------------
    */

    Route::middleware('permission:manage-user')->group(function () {
        Route::get('/daftar-users', fn () => view('pages.administrator.user-management-page.users'))->name('administrator.users');

        Route::prefix('api/admin')->group(function () {
            Route::get('/users',          [UserController::class, 'index']);
            Route::post('/users',         [UserController::class, 'store']);
            Route::put('/users/{id}',     [UserController::class, 'update']);
            Route::delete('/users/{id}',  [UserController::class, 'destroy']);
        });
    });

    Route::middleware('permission:manage-role')->group(function () {
        Route::get('/daftar-roles', fn () => view('pages.administrator.user-management-page.roles'))->name('administrator.roles');

        Route::prefix('api/admin')->group(function () {
            Route::get('/roles',          [RoleController::class, 'index']);
            Route::post('/roles',         [RoleController::class, 'store']);
            Route::put('/roles/{id}',     [RoleController::class, 'update']);
            Route::delete('/roles/{id}',  [RoleController::class, 'destroy']);
        });
    });

    Route::middleware('permission:manage-permission')->group(function () {
        Route::get('/daftar-permissions', fn () => view('pages.administrator.user-management-page.permissions'))->name('administrator.permissions');

        Route::prefix('api/admin')->group(function () {
            Route::get('/permissions',          [PermissionController::class, 'index']);
            Route::post('/permissions',         [PermissionController::class, 'store']);
            Route::put('/permissions/{id}',     [PermissionController::class, 'update']);
            Route::delete('/permissions/{id}',  [PermissionController::class, 'destroy']);
        });
    });
});