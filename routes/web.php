<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ViolationTypeController;
use App\Http\Controllers\DisciplineActionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\GradeMajorController;

// ═══════════════════════════════════════════
// PUBLIC (tidak butuh login)
// ═══════════════════════════════════════════

Route::get("/", function () {
    return view("pages.welcome");
})->name("home");

Route::get("/lapor", function () {
    return view("pages.user.report-page.report");
})->name("lapor.index");

Route::get("/lacak", function () {
    return view("pages.user.track-page.track");
})->name("lapor.lacak");

Route::get("/progress-laporan", function () {
    return view("pages.user.track-page.report-progress");
})->name("lapor.progress");

Route::get("/contact", function () {
    return view("pages.user.contact-page.contact");
})->name("lapor.contact");

Route::post("/api/reports/feedback", [ReportController::class, "storeFeedback"])
    ->middleware("throttle:3,1")
    ->name("api.reports.feedback");

// ═══════════════════════════════════════════
// API PUBLIC — Laporan & Siswa
// (tidak butuh login, dipakai oleh form publik)
// ═══════════════════════════════════════════

// Cari siswa berdasarkan NISN (dipanggil dari form laporan)
Route::get("/api/students/search", [ReportController::class, "searchStudent"])
    ->name("api.students.search");

// Autocomplete nama/NIS siswa (untuk field pelaku/korban/saksi di admin)
Route::get("/api/students/autocomplete", [ReportController::class, "autocompleteStudent"])
    ->name("api.students.autocomplete");

// Kirim laporan baru
Route::post("/api/reports", [ReportController::class, "store"])
    ->middleware("throttle:5,1") // maks 5 submit per menit per IP
    ->name("api.reports.store");

// Lacak laporan berdasarkan kode tiket
Route::get("/api/reports/track", [ReportController::class, "track"])
    ->name("api.reports.track");

Route::post("/api/reports/reminder", [ReportController::class, "sendReminder"])
    ->middleware("throttle:3,1") // maks 3 request per menit per IP
    ->name("api.reports.reminder");

Route::post("/api/reports/detail", [ReportController::class, "storeDetail"])
    ->middleware("throttle:10,1")
    ->name("api.reports.detail");

// Rute list Kelas dan Jurusan untuk Form Public
Route::get("/api/data-siswa/grades", [GradeMajorController::class, "gradesList"])
     ->name("api.students.grades.public");

Route::get("/api/data-siswa/majors", [GradeMajorController::class, "majorsList"])
     ->name("students.api.majors.public");

// ✅ BARU: Pasangan kelas-jurusan & jurusan lengkap — dipakai halaman /progress-laporan (publik)
Route::get("/api/data-siswa/grade-majors", [GradeMajorController::class, "pairsList"])
     ->name("api.grade.majors.pairs.public");

Route::get("/api/data-siswa/majors/full", [GradeMajorController::class, "majorsFullList"])
     ->name("students.api.majors.full.public");


// ═══════════════════════════════════════════
// HALAMAN LOGIN (tidak butuh login)
// ═══════════════════════════════════════════

Route::get("/login", function () {
    if (Auth::check()) {
        return redirect()->route("administrator.dashboard");
    }
    return view("pages.administrator.login-page.login");
})->name("administrator.login");

// ═══════════════════════════════════════════
// API AUTH
// ═══════════════════════════════════════════

Route::post("/api/admin/login", [AuthController::class, "login"])->name("api.admin.login");


// ═══════════════════════════════════════════
// SEMUA ROUTE YANG BUTUH LOGIN
// ═══════════════════════════════════════════

Route::middleware("auth:web")->group(function () {

    // ── API Auth ─────────────────────────────
    Route::match(['GET', 'POST'], "/api/admin/logout", [AuthController::class, "logout"])->name("api.admin.logout");
    Route::get("/api/admin/me",      [AuthController::class, "me"])->name("api.admin.me");

    // ── API Admin: Kelola Laporan ─────────────
    Route::prefix("api/admin")->group(function () {

        // Daftar laporan per status (untuk halaman admin)
        Route::get("/reports",              [ReportController::class, "adminIndex"]);
        Route::get("/reports/{id}",         [ReportController::class, "adminShow"]);
        Route::put("/reports/{id}/status",  [ReportController::class, "updateStatus"]);

        // Pihak yang terlibat (pelaku/korban/saksi)
        Route::post  ("/reports/{id}/persons",              [ReportController::class, "storePerson"]);
        Route::delete("/reports/{id}/persons/{personId}",   [ReportController::class, "destroyPerson"]);

        Route::get("/discipline-actions", [DisciplineActionController::class, "list"]); // ✅ hapus 
        Route::post("/reports/{id}/follow-up", [ReportController::class, "storeFollowUp"]);
        Route::put("/reports/{id}/follow-up/{followUpId}", [ReportController::class, "updateFollowUp"]);

    });

    // ── API User Management ───────────────────
    Route::prefix("api/admin")->group(function () {

        // Users
        Route::get   ("/users",      [UserController::class, "index"]);
        Route::post  ("/users",      [UserController::class, "store"]);
        Route::put   ("/users/{id}", [UserController::class, "update"]);
        Route::delete("/users/{id}", [UserController::class, "destroy"]);

        // Roles
        Route::get   ("/roles",      [RoleController::class, "index"]);
        Route::post  ("/roles",      [RoleController::class, "store"]);
        Route::put   ("/roles/{id}", [RoleController::class, "update"]);
        Route::delete("/roles/{id}", [RoleController::class, "destroy"]);

        // Permissions
        Route::get   ("/permissions",      [PermissionController::class, "index"]);
        Route::post  ("/permissions",      [PermissionController::class, "store"]);
        Route::put   ("/permissions/{id}", [PermissionController::class, "update"]);
        Route::delete("/permissions/{id}", [PermissionController::class, "destroy"]);

    });

    // ── Halaman Dashboard ─────────────────────
    Route::get("/dashboard", function () {
        return view("pages.administrator.dashboard-page.dashboard");
    })->name("administrator.dashboard");

    // ── Report Central ────────────────────────
    Route::get("/laporan-masuk", function () {
        return view("pages.administrator.report-management-page.incoming-report");
    })->name("administrator.incoming-report");

    Route::get("/menunggu-verifikasi", function () {
        return view("pages.administrator.report-management-page.pending-verification");
    })->name("administrator.pending-verification");

    Route::get("/proses-laporan", function () {
        return view("pages.administrator.report-management-page.processing-report");
    })->name("administrator.processing-report");

    Route::get("/laporan-selesai", function () {
        return view("pages.administrator.report-management-page.report-closed");
    })->name("administrator.report-closed");

    Route::get("/laporan-ditolak", function () {
        return view("pages.administrator.report-management-page.report-rejected");
    })->name("administrator.report-rejected");

    // ── Master Data ───────────────────────────
    Route::prefix("SIP-Bullying")->group(function () {

        // Data Siswa
        Route::get("/data-siswa", [StudentController::class, "index"])
            ->name("administrator.students");
        Route::get("/api/data-siswa/list", [StudentController::class, "getStudents"])
            ->name("students.api.list");
        Route::post("/api/data-siswa/save", [StudentController::class, "store"])
            ->name("students.api.save");
        Route::delete("/api/data-siswa/delete/{id}", [StudentController::class, "destroy"])
            ->name("students.api.delete");

        // ── Kelas & Jurusan (API GradeMajorController) ──
        Route::post("/api/data-siswa/majors/save", [GradeMajorController::class, "majorSave"])
            ->name("students.api.majors.save");
        Route::delete("/api/data-siswa/majors/delete/{name}", [GradeMajorController::class, "majorDelete"])
            ->name("students.api.majors.delete");

        Route::post("/api/data-siswa/grades/save", [GradeMajorController::class, "gradeSave"])
            ->name("students.api.grades.save");
        Route::delete("/api/data-siswa/grades/delete/{grade}", [GradeMajorController::class, "gradeDelete"])
            ->name("students.api.grades.delete");

        // ── Pasangan Kelas-Jurusan (admin, butuh login) ──
        Route::get("/api/data-siswa/grade-majors", [GradeMajorController::class, "pairsList"])
            ->name("api.grade.majors.pairs");
        Route::get("/api/data-siswa/grades-by-major/{major}", [GradeMajorController::class, "gradesByMajor"])
            ->name("api.grades.by.major");
        Route::get("/api/data-siswa/major-by-grade/{grade}", [GradeMajorController::class, "majorByGrade"])
            ->name("api.major.by.grade");

        // Jenis Pelanggaran
        Route::get("/jenis-pelanggaran", [ViolationTypeController::class, "index"])
            ->name("administrator.violation-types");
        Route::get("/api/jenis-pelanggaran/list", [ViolationTypeController::class, "list"])
            ->name("violation-types.api.list");
        Route::post("/api/jenis-pelanggaran/save", [ViolationTypeController::class, "store"])
            ->name("violation-types.api.save");
        Route::delete("/api/jenis-pelanggaran/delete/{id}", [ViolationTypeController::class, "destroy"])
            ->name("violation-types.api.delete");

        // Tindakan Disiplin
        Route::get("/tindakan-disiplin", [DisciplineActionController::class, "index"])
            ->name("administrator.discipline-actions");
        Route::get("/api/tindakan-disiplin/list", [DisciplineActionController::class, "list"])
            ->name("discipline-actions.api.list");
        Route::post("/api/tindakan-disiplin/save", [DisciplineActionController::class, "store"])
            ->name("discipline-actions.api.save");
        Route::delete("/api/tindakan-disiplin/delete/{id}", [DisciplineActionController::class, "destroy"])
            ->name("discipline-actions.api.delete");

    });

    // ── User Management ───────────────────────
    Route::get("/daftar-users", function () {
        return view("pages.administrator.user-management-page.users");
    })->name("administrator.users");

    Route::get("/daftar-roles", function () {
        return view("pages.administrator.user-management-page.roles");
    })->name("administrator.roles");

    Route::get("/daftar-permissions", function () {
        return view("pages.administrator.user-management-page.permissions");
    })->name("administrator.permissions");

    // ── Case Recapitulation ───────────────────
    Route::get("/rekapitulasi-PerBulan", function () {
        return view("pages.administrator.case-recapitulation-page.monthly");
    })->name("administrator.monthly");

    Route::get("/rekapitulasi-PerSemester", function () {
        return view("pages.administrator.case-recapitulation-page.semester");
    })->name("administrator.semester");

});