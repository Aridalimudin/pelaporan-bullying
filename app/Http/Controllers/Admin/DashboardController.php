<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user      = User::with('roles')->findOrFail(Auth::id());
        $today     = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        // ════════════════════════════════════════════════════════
        // BARIS 1 — Antrian Aktif (semua tanggal, status saat ini)
        // Menjawab: "Berapa beban kerja admin sekarang?"
        // ════════════════════════════════════════════════════════
        $antrian = [
            'belum'    => Report::where('status', 'masuk')->count(),
            'diproses' => Report::where('status', 'diproses')->count(),
            'menunggu' => Report::where('status', 'menunggu')->count(),
            'total'    => Report::whereNotIn('status', ['selesai', 'ditolak'])->count(),
        ];

        $antrianKemarin = [
            'belum'    => Report::where('status', 'masuk')->whereDate('created_at', '<=', $yesterday)->count(),
            'diproses' => Report::where('status', 'diproses')->whereDate('updated_at', $yesterday)->count(),
            'menunggu' => Report::where('status', 'menunggu')->whereDate('updated_at', $yesterday)->count(),
            'total'    => Report::whereNotIn('status', ['selesai', 'ditolak'])->whereDate('created_at', '<=', $yesterday)->count(),
        ];

        // ════════════════════════════════════════════════════════
        // BARIS 2 — Aktivitas Hari Ini (created/updated = today)
        // Menjawab: "Apa yang terjadi hari ini?"
        // ════════════════════════════════════════════════════════
        $hariIni = [
            'masuk'   => Report::whereDate('created_at', $today)->count(),
            'selesai' => Report::whereDate('updated_at', $today)->where('status', 'selesai')->count(),
            'ditolak' => Report::whereDate('updated_at', $today)->where('status', 'ditolak')->count(),
        ];

        $hariIniKemarin = [
            'masuk'   => Report::whereDate('created_at', $yesterday)->count(),
            'selesai' => Report::whereDate('updated_at', $yesterday)->where('status', 'selesai')->count(),
            'ditolak' => Report::whereDate('updated_at', $yesterday)->where('status', 'ditolak')->count(),
        ];

        // ════════════════════════════════════════════════════════
        // Urgensi — dari antrian AKTIF (bukan hanya hari ini)
        // Kolom di DB: 'urgency', enum: 'rendah','sedang','tinggi'
        // ════════════════════════════════════════════════════════
        $totalUrgensi = max($antrian['total'], 1);
        $urgensi = [
            'tinggi' => Report::whereNotIn('status', ['selesai', 'ditolak'])->where('urgency', 'tinggi')->count(),
            'sedang' => Report::whereNotIn('status', ['selesai', 'ditolak'])->where('urgency', 'sedang')->count(),
            'rendah' => Report::whereNotIn('status', ['selesai', 'ditolak'])->where('urgency', 'rendah')->count(),
        ];

        // ════════════════════════════════════════════════════════
        // Jenis Kasus — 0 sementara, aktif setelah violation_type_id
        // ada di tabel reports dan dihubungkan ke violation_types
        // ════════════════════════════════════════════════════════
        $totalJenis = max($antrian['total'], 1);
        $jenis = [
            'verbal'    => 0,
            'nonverbal' => 0,
        ];

        return view('pages.administrator.dashboard-page.dashboard', compact(
            'user',
            'antrian', 'antrianKemarin',
            'hariIni', 'hariIniKemarin',
            'urgensi', 'totalUrgensi',
            'jenis',   'totalJenis'
        ));
    }
}