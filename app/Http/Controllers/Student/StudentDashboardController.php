<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        // Ambil semua laporan milik siswa ini
        $allReports = Report::where('student_id', $student->id)
            ->orderByDesc('created_at')
            ->get();

        $reports = $allReports->take(10);

        $stats = [
            'total'     => $allReports->count(),
            'pending'   => $allReports->whereIn('status', ['masuk', 'menunggu', 'pending', 'submitted'])->count(),
            'proses'    => $allReports->whereIn('status', ['diproses', 'terverifikasi', 'verified', 'in_progress', 'proses'])->count(),
            'selesai'   => $allReports->whereIn('status', ['selesai', 'closed', 'done', 'resolved'])->count(),
            'ditolak'   => $allReports->whereIn('status', ['ditolak', 'rejected'])->count(),
        ];

        // Chart data distribution
        $chartData = [
            'pending'   => $stats['pending'],
            'proses'    => $stats['proses'],
            'selesai'   => $stats['selesai'],
            'ditolak'   => $stats['ditolak'],
        ];

        return view('pages.user.dashboard.index', compact('student', 'reports', 'allReports', 'stats', 'chartData'));
    }
}
