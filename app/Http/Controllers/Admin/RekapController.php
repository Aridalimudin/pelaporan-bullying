<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapController extends Controller
{
    // ══════════════════════════════════════════
    // REKAP PER BULAN
    // ══════════════════════════════════════════

    public function bulan(Request $request): JsonResponse
    {
        $bulan = (int) $request->query('bulan', now()->month);
        $tahun = (int) $request->query('tahun', now()->year);

        $namaBulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];
        $periodeLabel    = ($namaBulan[$bulan] ?? '-') . ' ' . $tahun;
        $hariDalamBulan  = Carbon::create($tahun, $bulan, 1)->daysInMonth;

        // ── Stats ──────────────────────────────────────────────
        $totalLaporan = Report::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)->count();

        $totalSelesai = Report::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->where('status', 'selesai')->count();

        $rataRata            = $totalLaporan > 0
            ? number_format($totalLaporan / $hariDalamBulan, 1) : '0.0';
        $tingkatPenyelesaian = $totalLaporan > 0
            ? round(($totalSelesai / $totalLaporan) * 100) : 0;

        // ── Chart per hari ─────────────────────────────────────
        $chartRaw = Report::selectRaw('DAY(created_at) as hari, COUNT(*) as total')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('hari')->orderBy('hari')
            ->pluck('total', 'hari');

        $chartLabels = [];
        $chartData   = [];
        for ($d = 1; $d <= $hariDalamBulan; $d++) {
            $chartLabels[] = (string) $d;
            $chartData[]   = (int) ($chartRaw[$d] ?? 0);
        }

        $peakVal  = count($chartData) ? max($chartData) : 0;
        $peakHari = $peakVal > 0 ? (array_search($peakVal, $chartData) + 1) : null;

        // ── Tabel per kelas ────────────────────────────────────
        $tabel = Report::join('students', 'reports.student_id', '=', 'students.id')
            ->selectRaw("
                CONCAT(students.grade, ' ', students.major) as kelas,
                COUNT(*) as total,
                SUM(CASE WHEN reports.status = 'selesai' THEN 1 ELSE 0 END) as selesai
            ")
            ->whereMonth('reports.created_at', $bulan)
            ->whereYear('reports.created_at', $tahun)
            ->groupBy('students.grade', 'students.major')
            ->orderByDesc('total')->get()
            ->map(fn($r) => [
                'periode' => $periodeLabel,
                'kelas'   => $r->kelas,
                'total'   => (int) $r->total,
                'selesai' => (int) $r->selesai,
            ])->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'stats' => compact(
                    'totalLaporan','rataRata','tingkatPenyelesaian','periodeLabel'
                ),
                'chart' => [
                    'labels'   => $chartLabels,
                    'data'     => $chartData,
                    'peakVal'  => $peakVal,
                    'peakHari' => $peakHari,
                ],
                'tabel' => $tabel,
            ],
        ]);
    }

    public function exportBulan(Request $request)
    {
        $bulan = (int) $request->query('bulan', now()->month);
        $tahun = (int) $request->query('tahun', now()->year);

        $namaBulan    = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];
        $periodeLabel = ($namaBulan[$bulan] ?? '-') . ' ' . $tahun;

        // Ambil data stats & tabel — reuse logika bulan()
        $dataResponse = $this->bulan($request);
        $data         = json_decode($dataResponse->getContent(), true)['data'];

        // Tambahkan kolom ditolak ke tabel
        $tabel = collect($data['tabel'])->map(function ($row) {
            $row['ditolak'] = $row['total'] - $row['selesai'];
            return $row;
        })->toArray();

        $stats = array_merge($data['stats'], [
            'selesai' => collect($tabel)->sum('selesai'),
            'ditolak' => collect($tabel)->sum('ditolak'),
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.rekap-ringkasan', [
            'tipe'         => 'Rekap Bulan',
            'periodeLabel' => $periodeLabel,
            'stats'        => $stats,
            'tabel'        => $tabel,
        ]);

        $pdf->setPaper('A4', 'portrait');
        $filename = 'rekap-bulan-' . $bulan . '-' . $tahun . '.pdf';
        return $pdf->download($filename);
    }

    // ══════════════════════════════════════════
    // REKAP PER SEMESTER
    // ══════════════════════════════════════════

    public function semester(Request $request): JsonResponse
    {
        $semester    = $request->query('semester', 'genap'); // 'ganjil' | 'genap'
        $tahunAjaran = $request->query('tahun_ajaran', '2025/2026'); // format "2025/2026"

        // Parse tahun ajaran → tahun mulai & akhir
        [$tahunMulai, $tahunAkhir] = explode('/', $tahunAjaran);
        $tahunMulai = (int) $tahunMulai;
        $tahunAkhir = (int) $tahunAkhir;

        // Semester ganjil: Juli–Desember (tahunMulai)
        // Semester genap : Januari–Juni  (tahunAkhir)
        if ($semester === 'ganjil') {
            $bulanMulai  = 7;
            $bulanAkhir  = 12;
            $tahunFilter = $tahunMulai;
            $bulanLabels = ['Jul','Ags','Sep','Okt','Nov','Des'];
            $bulanNums   = [7, 8, 9, 10, 11, 12];
        } else {
            $bulanMulai  = 1;
            $bulanAkhir  = 6;
            $tahunFilter = $tahunAkhir;
            $bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun'];
            $bulanNums   = [1, 2, 3, 4, 5, 6];
        }

        $periodeLabel = 'Semester ' . ucfirst($semester) . ' ' . $tahunAjaran;

        // ── Stats ──────────────────────────────────────────────
        $totalLaporan = Report::whereYear('created_at', $tahunFilter)
            ->whereBetween(
                DB::raw('MONTH(created_at)'),
                [$bulanMulai, $bulanAkhir]
            )->count();

        $totalSelesai = Report::whereYear('created_at', $tahunFilter)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanMulai, $bulanAkhir])
            ->where('status', 'selesai')->count();

        // Jumlah hari dalam rentang semester
        $hariTotal = 0;
        foreach ($bulanNums as $bln) {
            $hariTotal += \Carbon\Carbon::create($tahunFilter, $bln, 1)->daysInMonth;
        }

        $rataRata            = $totalLaporan > 0
            ? number_format($totalLaporan / $hariTotal, 1) : '0.0';
        $tingkatPenyelesaian = $totalLaporan > 0
            ? round(($totalSelesai / $totalLaporan) * 100) : 0;

        // ── Chart per bulan ────────────────────────────────────
        $chartRaw = Report::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahunFilter)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanMulai, $bulanAkhir])
            ->groupBy('bulan')->orderBy('bulan')
            ->pluck('total', 'bulan');

        $chartData = [];
        foreach ($bulanNums as $bln) {
            $chartData[] = (int) ($chartRaw[$bln] ?? 0);
        }

        $peakVal  = count($chartData) ? max($chartData) : 0;
        $peakIdx  = $peakVal > 0 ? array_search($peakVal, $chartData) : null;
        $peakLabel = $peakIdx !== null ? $bulanLabels[$peakIdx] . ' ' . $tahunFilter : null;

        // ── Tabel per kelas ────────────────────────────────────
        $tabel = Report::join('students', 'reports.student_id', '=', 'students.id')
            ->selectRaw("
                CONCAT(students.grade, ' ', students.major) as kelas,
                COUNT(*) as total,
                SUM(CASE WHEN reports.status = 'selesai' THEN 1 ELSE 0 END) as selesai
            ")
            ->whereYear('reports.created_at', $tahunFilter)
            ->whereBetween(DB::raw('MONTH(reports.created_at)'), [$bulanMulai, $bulanAkhir])
            ->groupBy('students.grade', 'students.major')
            ->orderByDesc('total')->get()
            ->map(fn($r) => [
                'periode' => $periodeLabel,
                'kelas'   => $r->kelas,
                'total'   => (int) $r->total,
                'selesai' => (int) $r->selesai,
            ])->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'stats' => compact(
                    'totalLaporan','rataRata','tingkatPenyelesaian','periodeLabel'
                ),
                'chart' => [
                    'labels'    => $bulanLabels,
                    'data'      => $chartData,
                    'peakVal'   => $peakVal,
                    'peakLabel' => $peakLabel,
                ],
                'tabel' => $tabel,
            ],
        ]);
    }

    public function exportSemester(Request $request)
    {
        $semester    = $request->query('semester', 'genap');
        $tahunAjaran = $request->query('tahun_ajaran', '2025/2026');
        $periodeLabel = 'Semester ' . ucfirst($semester) . ' ' . $tahunAjaran;

        $dataResponse = $this->semester($request);
        $data         = json_decode($dataResponse->getContent(), true)['data'];

        $tabel = collect($data['tabel'])->map(function ($row) {
            $row['ditolak'] = $row['total'] - $row['selesai'];
            return $row;
        })->toArray();

        $stats = array_merge($data['stats'], [
            'selesai' => collect($tabel)->sum('selesai'),
            'ditolak' => collect($tabel)->sum('ditolak'),
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.rekap-ringkasan', [
            'tipe'         => 'Rekap Semester',
            'periodeLabel' => $periodeLabel,
            'stats'        => $stats,
            'tabel'        => $tabel,
        ]);

        $pdf->setPaper('A4', 'portrait');
        $filename = 'rekap-semester-' . $semester . '-' . str_replace('/', '-', $tahunAjaran) . '.pdf';
        return $pdf->download($filename);
    }

        /**
     * GET /api/admin/rekap/detail-kelas
     * Detail laporan per kelas untuk drawer
     * ?kelas=X+AKL-1&bulan=3&tahun=2026
     * ?kelas=X+AKL-1&semester=genap&tahun_ajaran=2025/2026
     */
    public function detailKelas(Request $request): JsonResponse
    {
        $kelas = trim($request->query('kelas', ''));
        if (empty($kelas)) {
            return response()->json(['success' => false, 'message' => 'Parameter kelas wajib diisi.'], 422);
        }

        $parts = explode(' ', $kelas, 2);
        $grade = $parts[0] ?? '';
        $major = $parts[1] ?? '';

        $bulan       = $request->query('bulan');
        $tahun       = $request->query('tahun');
        $semester    = $request->query('semester');
        $tahunAjaran = $request->query('tahun_ajaran');

        $query = Report::join('students', 'reports.student_id', '=', 'students.id')
            ->where('students.grade', $grade)
            ->where('students.major', $major);

        $periodeLabel = '';

        if ($bulan && $tahun) {
            $query->whereMonth('reports.created_at', (int) $bulan)
                ->whereYear('reports.created_at', (int) $tahun);
            $namaBulan = [
                1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
            ];
            $periodeLabel = ($namaBulan[(int)$bulan] ?? '-') . ' ' . $tahun;

        } elseif ($semester && $tahunAjaran) {
            [$tahunMulai, $tahunAkhir] = explode('/', $tahunAjaran);
            if ($semester === 'ganjil') {
                $bulanMulai = 7; $bulanAkhir = 12;
                $tahunFilter = (int) $tahunMulai;
            } else {
                $bulanMulai = 1; $bulanAkhir = 6;
                $tahunFilter = (int) $tahunAkhir;
            }
            $query->whereYear('reports.created_at', $tahunFilter)
                ->whereBetween(DB::raw('MONTH(reports.created_at)'), [$bulanMulai, $bulanAkhir]);
            $periodeLabel = 'Semester ' . ucfirst($semester) . ' ' . $tahunAjaran;
        } else {
            return response()->json(['success' => false, 'message' => 'Parameter periode tidak lengkap.'], 422);
        }

        $laporan = $query->select([
                'reports.id',
                'reports.ticket_code',
                'reports.status',
                'reports.urgency',
                'reports.created_at',
                'reports.handled_at',
                'students.fullname as student_name',
            ])
            ->orderByDesc('reports.created_at')
            ->get();

        $total   = $laporan->count();
        // Hanya hitung status terminal
        $selesai = $laporan->where('status', 'selesai')->count();
        $ditolak = $laporan->where('status', 'ditolak')->count();

        // Urgensi — hanya dari laporan yang sudah selesai/ditolak
        $terminal = $laporan->whereIn('status', ['selesai', 'ditolak']);
        $urgTinggi = $terminal->where('urgency', 'tinggi')->count();
        $urgSedang = $terminal->where('urgency', 'sedang')->count();
        $urgRendah = $terminal->where('urgency', 'rendah')->count();

        // Hanya tampilkan laporan terminal di tabel
        $tabelLaporan = $laporan->whereIn('status', ['selesai', 'ditolak'])
            ->map(fn($r) => [
                'ticket_code'  => $r->ticket_code,
                'student_name' => $r->student_name,
                'status'       => $r->status,
                'urgency'      => $r->urgency ?? 'sedang',
                'created_at'   => Carbon::parse($r->created_at)->format('d M Y'),
                'handled_at'   => $r->handled_at
                    ? Carbon::parse($r->handled_at)->format('d M Y')
                    : '-',
            ])->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'kelas'        => $kelas,
                'periodeLabel' => $periodeLabel,
                'stats' => [
                    'total'   => $total,
                    'selesai' => $selesai,
                    'ditolak' => $ditolak,
                    'pct'     => $total > 0 ? round(($selesai / $total) * 100) : 0,
                ],
                'urgensi' => [
                    'tinggi' => $urgTinggi,
                    'sedang' => $urgSedang,
                    'rendah' => $urgRendah,
                ],
                'laporan' => $tabelLaporan,
            ],
        ]);
    }
    /**
     * GET /api/admin/rekap/download-kelas
     * Download PDF rekap per kelas
     */
    public function downloadKelas(Request $request)
    {
        $kelas = trim($request->query('kelas', ''));
        if (empty($kelas)) abort(422, 'Parameter kelas wajib diisi.');

        // Ambil data — reuse logika detailKelas
        $detailResponse = $this->detailKelas($request);
        $detailData     = json_decode($detailResponse->getContent(), true);

        if (!$detailData['success']) abort(422, $detailData['message']);

        $data = $detailData['data'];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.rekap-kelas', [
            'kelas'        => $data['kelas'],
            'periodeLabel' => $data['periodeLabel'],
            'stats'        => $data['stats'],
            'urgensi'      => $data['urgensi'],
            'laporan'      => $data['laporan'],
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'rekap-kelas-' . str_replace(' ', '-', $kelas) . '-' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    // ══════════════════════════════════════════
    // HELPER
    // ══════════════════════════════════════════

    private function streamCsv(string $filename, array $headers, $rows, string $periodeLabel)
    {
        return response()->stream(function () use ($headers, $rows, $periodeLabel) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($rows as $i => $row) {
                $pct = $row->total > 0 ? round(($row->selesai / $row->total) * 100) : 0;
                fputcsv($handle, [
                    $i + 1, $periodeLabel, $row->kelas,
                    $row->total, $row->selesai, $pct . '%',
                ]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}