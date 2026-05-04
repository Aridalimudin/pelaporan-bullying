<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportFile;
use App\Models\ReportPerson;
use App\Models\Student;
use App\Models\DisciplineAction;
use App\Models\ReportFollowUp;
use App\Models\FollowUpFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    // ── Allowed MIME types untuk bukti ──────────
    private const ALLOWED_MIME = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
        'video/mp4',
        'video/quicktime',  // .mov
        'video/x-msvideo',  // .avi
        'video/webm',
    ];

    private const MAX_FILE_SIZE = 50 * 1024 * 1024; // 50MB per file (video bisa besar)
    private const MAX_IMG_SIZE  = 5  * 1024 * 1024; // 5MB untuk gambar

    private function notifyAllUsers(
        string $type,
        string $title,
        string $body,
        string $icon,
        string $color,
        string $url
    ): void {
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type'    => $type,
                'title'   => $title,
                'body'    => $body,
                'icon'    => $icon,
                'color'   => $color,
                'url'     => $url,
                'read_at' => null,
            ]);
        }
    }

    // ══════════════════════════════════════════════════════════
    // PUBLIC ENDPOINTS
    // ══════════════════════════════════════════════════════════

    /**
     * GET /api/students/search?nisn=xxxxx
     * Cari siswa berdasarkan NIS/NISN.
     */
    public function searchStudent(Request $request): JsonResponse
    {
        $nisn = trim($request->query('nisn', ''));

        if (strlen($nisn) < 4) {
            return response()->json(['success' => false, 'message' => 'Masukkan minimal 4 digit NISN.'], 422);
        }

        $student = Student::where('nis', $nisn)->first();

        if (! $student) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan. Periksa kembali atau hubungi wali kelas.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id'       => $student->id,
                'fullname' => $student->fullname,
                'grade'    => $student->grade,
                'major'    => $student->major,
                'gender'   => $student->gender,
                'email'    => $student->email,
                'has_email'=> ! empty($student->email),
            ],
        ]);
    }

    /**
     * GET /api/students/autocomplete?q=nama_atau_nis
     * Autocomplete siswa — dipakai field pelaku/korban/saksi di sisi admin.
     */
    public function autocompleteStudent(Request $request): JsonResponse
    {
        $q = trim($request->query('q', ''));

        if (strlen($q) < 2) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $students = Student::where('fullname', 'like', "%{$q}%")
            ->orWhere('nis', 'like', "%{$q}%")
            ->orderBy('fullname')
            ->limit(10)
            ->get(['id', 'fullname', 'nis', 'grade', 'major', 'gender']);

        return response()->json([
            'success' => true,
            'data'    => $students->map(fn ($s) => [
                'id'       => $s->id,
                'fullname' => $s->fullname,
                'nis'      => $s->nis,
                'grade'    => $s->grade,
                'major'    => $s->major,
                'gender'   => $s->gender,
                'label'    => "{$s->fullname} ({$s->nis}) — {$s->grade} {$s->major}",
            ]),
        ]);
    }

    /**
     * POST /api/reports
     * Kirim laporan baru.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nisn'        => 'required|string|max:20',
                'email'       => 'required|email|max:255',
                'deskripsi'   => 'required|string|min:20|max:5000',
                'student_id'  => 'nullable|exists:students,id',
                'bukti'       => 'nullable|array|max:5',
                'bukti.*'     => 'file|max:51200', // 50MB, validasi MIME manual di bawah
            ], [
                'nisn.required'      => 'NISN wajib diisi.',
                'email.required'     => 'Email wajib diisi.',
                'email.email'        => 'Format email tidak valid.',
                'deskripsi.required' => 'Deskripsi kejadian wajib diisi.',
                'deskripsi.min'      => 'Deskripsi minimal 20 karakter.',
                'bukti.max'          => 'Maksimal 5 file bukti.',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }

        // Validasi manual MIME type file bukti
        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                $mime = $file->getMimeType();

                if (! in_array($mime, self::ALLOWED_MIME)) {
                    return response()->json([
                        'success' => false,
                        'message' => "File '{$file->getClientOriginalName()}' tidak didukung. Hanya foto (JPG, PNG, WEBP) dan video (MP4, MOV, AVI, WEBM).",
                    ], 422);
                }

                // Batas ukuran berbeda untuk gambar vs video
                $maxSize = str_starts_with($mime, 'image/') ? self::MAX_IMG_SIZE : self::MAX_FILE_SIZE;
                if ($file->getSize() > $maxSize) {
                    $limitLabel = str_starts_with($mime, 'image/') ? '5MB' : '50MB';
                    return response()->json([
                        'success' => false,
                        'message' => "File '{$file->getClientOriginalName()}' terlalu besar. Batas: {$limitLabel}.",
                    ], 422);
                }
            }
        }

        DB::beginTransaction();
        try {
            // Buat laporan
            $report = Report::create([
                'ticket_code' => Report::generateTicketCode(),
                'nisn'        => $request->nisn,
                'email'       => $request->email,
                'student_id'  => $request->student_id ?? null,
                'deskripsi'   => $request->deskripsi,
                'status'      => 'masuk',
            ]);

            // Simpan file bukti
            if ($request->hasFile('bukti')) {
                foreach ($request->file('bukti') as $file) {
                    $storedName = $file->store("reports/{$report->id}", 'public');

                    ReportFile::create([
                        'report_id'     => $report->id,
                        'original_name' => $file->getClientOriginalName(),
                        'stored_name'   => $storedName,
                        'mime_type'     => $file->getMimeType(),
                        'size'          => $file->getSize(),
                    ]);
                }
            }

            // Update report_history siswa jika ditemukan
            if ($request->student_id) {
                Student::where('id', $request->student_id)->increment('report_history');
            }

            // Log aktivitas awal
            $report->logActivity('Laporan dikirim oleh pelapor.', null, 'masuk');

            $this->notifyAllUsers(
                'laporan_baru',
                'Laporan Baru Masuk',
                "Laporan baru #{$report->ticket_code} telah dikirim oleh pelapor.",
                'file',
                'green',
                '/laporan-masuk?open=' . $report->id
            );

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server.'], 500);
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Laporan berhasil dikirim.',
            'ticket_code' => $report->ticket_code,
        ], 201);
    }

    /**
     * GET /api/reports/track?code=KRF-xxxxx
     * Lacak progress laporan berdasarkan kode tiket.
     */
    public function track(Request $request): JsonResponse
    {
        $code = trim($request->query('code', ''));

        if (empty($code)) {
            return response()->json(['success' => false, 'message' => 'Kode tiket wajib diisi.'], 422);
        }

        $report = Report::with([
            'student',
            'handler:id,nama',
            'files',
            'persons.student',
            'activities.actor:id,nama',
            'followUp.files',
            'feedback',
        ])->where('ticket_code', strtoupper($code))->first();

        if (! $report) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tiket tidak ditemukan. Periksa kembali.',
            ], 404);
        }

        // Tentukan langkah progress (1–4)
        $step = match ($report->status) {
            'masuk'    => 1,
            'menunggu' => 2,
            'diproses' => 3,
            'selesai'  => 4,
            'ditolak'  => 4,
            default    => 1,
        };

        // Format helper untuk satu person
        $formatPerson = fn ($p) => [
            'id'            => $p->id,
            'role'          => $p->role,
            'role_label'    => $p->roleLabel(),
            'student_id'    => $p->student_id,
            'student_name'  => $p->student?->fullname,
            'student_nis'   => $p->student?->nis,
            'student_grade' => $p->student ? "{$p->student->grade} {$p->student->major}" : null,
            'name_manual'   => $p->name_manual,
            'grade_manual'  => $p->grade_manual,   // ← tambah
            'major_manual'  => $p->major_manual,
            'display_name'  => $p->displayName(),
            'notes'         => $p->notes,
        ];

        return response()->json([
            'success' => true,
            'data'    => [
                'ticket_code'       => $report->ticket_code,
                'status'            => $report->status,
                'status_label'      => $report->statusLabel(),
                'status_color'      => $report->statusColor(),
                'step'              => $step,
                'catatan_admin'     => $report->catatan_admin,
                'rejection_reason'     => $report->rejection_reason,  // ← TAMBAH
                'tahap_terakhir'       => $report->getRejectedFromStage(),
                'deskripsi'         => $report->deskripsi,        // ← TAMBAH INI
                'created_at'        => $report->created_at->format('d M Y, H:i'),
                'updated_at'        => $report->updated_at->format('d M Y, H:i'),
                'student_name'      => $report->student?->fullname,

                // ── Data tambahan (baru) ──────────────────────────────
                'student_grade'     => $report->student
                    ? "{$report->student->grade} {$report->student->major}"
                    : null,
                'student_nis'       => $report->nisn,
                'urgency'           => $report->urgency,
                'urgency_label'     => $report->urgencyLabel(),
                'incident_date'     => $report->incident_date?->format('d M Y'),
                'incident_time'     => $report->incident_time ?? null,
                'incident_date_raw' => $report->incident_date?->format('Y-m-d'),
                'incident_location' => $report->incident_location,
                'handler_nama'      => $report->handler?->nama,
                'can_send_reminder' => $report->canSendReminder(),
                'reminder_count'    => $report->reminder_count,

                // ── Pihak yang terlibat ───────────────────────────────
                'pelaku' => $report->persons
                    ->where('role', 'pelaku')
                    ->values()
                    ->map($formatPerson),
                'korban' => $report->persons
                    ->where('role', 'korban')
                    ->values()
                    ->map($formatPerson),
                'saksi'  => $report->persons
                    ->where('role', 'saksi')
                    ->values()
                    ->map($formatPerson),

                // ── Timeline aktivitas ────────────────────────────────
                'activities' => $report->activities->map(fn ($a) => [
                    'description' => $a->description,
                    'from_status' => $a->from_status,
                    'to_status'   => $a->to_status,
                    'notes'       => $a->notes,
                    'actor'       => match($a->actor_type ?? 'sistem') {
                        'pelapor' => $report->student?->fullname ?? 'Pelapor',
                        'admin'   => $a->actor?->nama ?? 'Admin',
                        default   => 'Sistem',
                    },
                    'dot_color'  => match($a->actor_type ?? 'sistem') {
                        'pelapor' => 'blue',
                        'admin'   => 'green',
                        default   => 'gray',
                    },
                    'created_at' => $a->created_at?->format('d M Y, H:i') ?? '-',
                ]),

                // ── File bukti (nama & mime saja — URL diambil terpisah) ─
                'files' => $report->files->map(fn ($f) => [
                    'id'            => $f->id,
                    'original_name' => $f->original_name,
                    'mime_type'     => $f->mime_type,
                    'size'          => $f->size,
                    'url'           => asset('storage/' . $f->stored_name),
                ]),
                'tindak_lanjut' => $report->followUp ? [
                    'jenis_tindakan'      => $report->followUp->jenis_tindakan,
                    'tanggal_pelaksanaan' => $report->followUp->tanggal_pelaksanaan?->format('d M Y'),
                    'deskripsi'           => $report->followUp->deskripsi,
                    'catatan_tambahan'    => $report->followUp->catatan_tambahan,
                    'pelaksana'           => $report->followUp->pelaksana,         // ← tambah
                    'keterlibatan_ortu'   => $report->followUp->keterlibatan_ortu, // ← tambah
                    'files'               => $report->followUp->files->map(fn($f) => [
                        'url'  => asset('storage/' . $f->stored_name),
                        'nama' => $f->original_name,
                        'mime' => $f->mime_type,
                    ]),
                ] : null,
                'feedback' => $report->feedback ? [
                    'rating' => $report->feedback->rating,
                    'pesan'  => $report->feedback->pesan,
                ] : null,
            ],
        ]);
    }

    /**
     * POST /api/reports/reminder
     * Kirim reminder ke admin (cooldown 24 jam per laporan).
     */
    public function sendReminder(Request $request): JsonResponse
    {
        $code = trim($request->input('code', ''));

        if (empty($code)) {
            return response()->json(['success' => false, 'message' => 'Kode tiket wajib diisi.'], 422);
        }

        $report = Report::where('ticket_code', strtoupper($code))->first();

        if (! $report) {
            return response()->json(['success' => false, 'message' => 'Kode tiket tidak ditemukan.'], 404);
        }

        // Status terminal tidak perlu reminder
        if (in_array($report->status, ['selesai', 'ditolak'])) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan sudah selesai atau ditolak. Reminder tidak diperlukan.',
            ], 422);
        }

        if (! $report->canSendReminder()) {
            return response()->json([
                'success' => false,
                'message' => 'Batas pengiriman reminder adalah 2 kali per hari. Coba lagi besok.',
            ], 429);
        }

        $report->increment('reminder_count');

        $report->logActivity('Pelapor mengirim reminder kepada petugas.');

        $urlMap = [
            'masuk'    => '/laporan-masuk',
            'menunggu' => '/menunggu-verifikasi',
            'diproses' => '/proses-laporan',
            'selesai'  => '/laporan-selesai',
            'ditolak'  => '/laporan-ditolak',
        ];
        $url = ($urlMap[$report->status] ?? '/laporan-masuk') . '?open=' . $report->id;

        $this->notifyAllUsers(
            'reminder',
            'Reminder Laporan',
            "Pelapor mengirim reminder untuk laporan #{$report->ticket_code}. Mohon segera ditindaklanjuti.",
            'bell',
            'yellow',
            $url
        );

        return response()->json([
            'success' => true,
            'message' => 'Reminder berhasil dikirim ke petugas.',
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // ADMIN ENDPOINTS (butuh auth:web)
    // ══════════════════════════════════════════════════════════

    /**
     * GET /api/admin/reports?status=masuk
     * Daftar laporan (untuk halaman admin), bisa filter per status.
     */
    public function adminIndex(Request $request): JsonResponse
    {
        // 1. Ambil data dari DB dengan relasi student
        $status = $request->query('status', 'masuk');

        $reports = Report::with(['student', 'files', 'persons.student', 'followUp', 'followUp.files'])
        ->where('status', $status)
        ->orderByDesc('created_at')
        ->get();

        // 2. Format ulang supaya cocok dengan struktur LAPORAN_DATA di JavaScript kamu
        $formattedData = $reports->mapWithKeys(function ($item) {
            return ['row-' . $item->id => [
                'id'        => $item->id,
                'kode'      => $item->ticket_code,
                'nama'      => $item->student->fullname ?? 'Pelapor Luar',
                'nis'       => $item->nisn,
                'kelas'     => $item->student ? ($item->student->grade . ' ' . $item->student->major) : '-',
                'urgensi'   => $item->urgency ?? 'sedang',
                'email'     => $item->email,
                'deskripsi' => $item->deskripsi,
                'tanggal' => $item->incident_date ? $item->incident_date->format('d M Y') : null,
                'tglSelesai' => $item->handled_at?->format('d M Y') ?? '-',
                'tglDitolak'         => $item->handled_at?->format('d M Y') ?? '-',   // ← TAMBAH alias untuk ditolak
                'alasanTolak'        => $item->rejection_reason ?? $item->catatan_admin ?? '-', // ← TAMBAH
                'tahapTerakhir'      => $item->getRejectedFromStage(),          
                'jenisTindakan'      => $item->followUp?->jenis_tindakan ?? '-',
                'tanggalTindak'      => $item->followUp?->tanggal_pelaksanaan?->format('d M Y') ?? '-',
                'deskripsiTindakan'  => $item->followUp?->deskripsi ?? '-',
                'catatanTambahan'    => $item->followUp?->catatan_tambahan ?? null,
                'pelaksana'          => $item->followUp?->pelaksana ?? null,          // ← TAMBAH
                'keterlibatanOrtu'   => $item->followUp?->keterlibatan_ortu ?? null,  // ← TAMBAH
                'feedback' => $item->feedback ? [
                    'rating' => $item->feedback->rating,
                    'pesan'  => $item->feedback->pesan,
                ] : null,
                // Tambahan data untuk modal detail agar lengkap
                'tempat'    => $item->incident_location ?? '-',
                'pelaku' => $item->persons->where('role', 'pelaku')->values()->map(fn($p) => [
                    'nama'    => $p->student?->fullname ?? $p->name_manual ?? '-',
                    'kelas'   => $p->student ? $p->student->grade : ($p->grade_manual ?? '-'),   // ← TAMBAH
                    'jurusan' => $p->student ? $p->student->major : ($p->major_manual ?? '-'),   // ← TAMBAH
                    'notes'   => $p->notes,
                ])->toArray(),
                'korban' => $item->persons->where('role', 'korban')->values()->map(fn($p) => [
                    'nama'    => $p->student?->fullname ?? $p->name_manual ?? '-',
                    'kelas'   => $p->student ? $p->student->grade : ($p->grade_manual ?? '-'),   // ← TAMBAH
                    'jurusan' => $p->student ? $p->student->major : ($p->major_manual ?? '-'),   // ← TAMBAH
                    'notes'   => $p->notes,
                ])->toArray(),
                'saksi'  => $item->persons->where('role', 'saksi')->values()->map(fn($p) => [
                    'nama'    => $p->student?->fullname ?? $p->name_manual ?? '-',
                    'kelas'   => $p->student ? $p->student->grade : ($p->grade_manual ?? '-'),   // ← TAMBAH
                    'jurusan' => $p->student ? $p->student->major : ($p->major_manual ?? '-'),   // ← TAMBAH
                    'notes'   => $p->notes,
                ])->toArray(),
                'followUpFiles'      => $item->followUp?->files->map(fn($f) => [
                    'url'  => asset('storage/' . $f->stored_name),
                    'nama' => $f->original_name,
                    'mime' => $f->mime_type,
                ])->toArray() ?? [],
                // Tambah jam
                'jam' => $item->incident_time ?? null,      
                'files'     => $item->files->map(function($f) {
                    return [
                        'url'  => asset('storage/' . $f->stored_name), 
                        'mime' => $f->mime_type
                    ];
                }),
            ]];
        });

        return response()->json([
            'success' => true, 
            'data'    => $formattedData
        ]);
    }

    /**
     * GET /api/admin/reports/{id}
     * Detail laporan lengkap untuk admin.
     */
    public function adminShow(int $id): JsonResponse
    {
        $report = Report::with([
            'student',
            'handler:id,nama',
            'files',
            'persons.student',
            'activities.actor:id,nama',
        ])->findOrFail($id);

        return response()->json(['success' => true, 'data' => $report]);
    }

    /**
     * PUT /api/admin/reports/{id}/status
     * Update status laporan oleh admin + opsional urgency & catatan.
     */
/**
     * PUT /api/admin/reports/{id}/status
     * Update status laporan oleh admin + opsional urgency & catatan.
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $report = Report::findOrFail($id);
        /** @var \App\Models\User $admin */
        $admin   = auth('web')->user();
        $adminId = $admin?->id;

        try {
            $request->validate([
                'status'  => 'required|in:masuk,menunggu,diproses,selesai,ditolak',
                'catatan' => 'nullable|string|max:1000',
                'urgency' => 'nullable|in:rendah,sedang,tinggi',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }

        $oldStatus = $report->status;
        $newStatus = $request->status;

        // ✅ Cegah update ke status yang sama
        if ($oldStatus === $newStatus && !$request->filled('urgency') && !$request->filled('catatan')) {
            return response()->json([
                'success' => false,
                'message' => 'Status sudah sama, tidak ada perubahan.',
            ], 422);
        }

        $updates = ['status' => $newStatus];
        
        if ($request->filled('urgency')) {
            $updates['urgency'] = $request->urgency;
        }

        // LOGIKA PENYIMPANAN
        if ($newStatus === 'ditolak') {
            $updates['rejection_reason']    = $request->catatan;
            $updates['catatan_admin']       = "Laporan ditolak oleh admin pada tahap " . $oldStatus;
            $updates['rejected_from_stage'] = $oldStatus; // simpan dari tahap mana ditolak
        } else {
            $updates['catatan_admin']       = $request->catatan ?? "Status diperbarui menjadi " . $newStatus;
            $updates['rejection_reason']    = null;
            $updates['rejected_from_stage'] = null;

            // Reset feedback saat laporan dipulihkan dari ditolak
            if ($oldStatus === 'ditolak') {
                $report->feedback()->delete();
            }
        }

        if (in_array($newStatus, ['menunggu', 'diproses', 'selesai', 'ditolak'])) {
            $updates['handled_by'] = $adminId;
            $updates['handled_at'] = now();
        }

        $oldLabel = $report->getOriginal('status') 
            ? $report->newInstance(['status' => $report->getOriginal('status')])->statusLabel()
            : $report->statusLabel();

        $report->update($updates);
        $newLabel = $report->fresh()->statusLabel();

        // Hanya log jika status benar-benar berubah
        $logDesc = $oldStatus !== $newStatus
            ? "Status diubah dari '{$oldLabel}' menjadi '{$newLabel}'."
            : "Laporan diperbarui (urgency/catatan).";

        $logDesc = $oldStatus !== $newStatus
        ? "Status diubah dari '{$oldLabel}' menjadi '{$newLabel}'."
        : "Laporan diperbarui (urgency/catatan).";

        $report->logActivity(
            $logDesc,
            $oldStatus,
            $newStatus,
            null,
            $adminId,
            'admin'
        );

        // ── TAMBAHKAN INI ──────────────────────────────────────────
        if ($oldStatus !== $newStatus) {
            $notifMap = [
                'menunggu' => [
                    'type'  => 'status_menunggu',
                    'title' => 'Laporan Menunggu Verifikasi',
                    'body'  => "Laporan #{$report->ticket_code} sedang menunggu verifikasi oleh {$admin->nama}.",
                    'icon'  => 'clock',
                    'color' => 'yellow',
                    'url'   => '/menunggu-verifikasi?open=' . $report->id,
                ],
                'diproses' => [
                    'type'  => 'status_diproses',
                    'title' => 'Laporan Sedang Diproses',
                    'body'  => "Laporan #{$report->ticket_code} sedang diproses oleh {$admin->nama}.",
                    'icon'  => 'clock',
                    'color' => 'blue',
                    'url'   => '/proses-laporan?open=' . $report->id,
                ],
                'selesai' => [
                    'type'  => 'status_selesai',
                    'title' => 'Laporan Diselesaikan',
                    'body'  => "Laporan #{$report->ticket_code} telah diselesaikan oleh {$admin->nama}.",
                    'icon'  => 'check',
                    'color' => 'green',
                    'url'   => '/laporan-selesai?open=' . $report->id,
                ],
                'ditolak' => [
                    'type'  => 'status_ditolak',
                    'title' => 'Laporan Ditolak',
                    'body'  => "Laporan #{$report->ticket_code} ditolak oleh {$admin->nama}.",
                    'icon'  => 'x',
                    'color' => 'red',
                    'url'   => '/laporan-ditolak?open=' . $report->id,
                ],
            ];

            if (isset($notifMap[$newStatus])) {
                $n = $notifMap[$newStatus];
                $this->notifyAllUsers($n['type'], $n['title'], $n['body'], $n['icon'], $n['color'], $n['url']);
            }
        }
// ── SAMPAI SINI ────────────────────────────────────────────

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui.',
            'data'    => $report->fresh(),
        ]);
    }

    /**
     * POST /api/admin/reports/{id}/persons
     * Tambah pelaku/korban/saksi.
     * Jika pelaku & korban sudah ada → otomatis berubah ke status 'diproses'.
     */
    public function storePerson(Request $request, int $id): JsonResponse
    {
        $report = Report::findOrFail($id);
        /** @var \App\Models\User $admin */
        $admin   = auth('web')->user();
        $adminId = $admin?->id;

        // Hanya bisa tambah saat status menunggu
        if ($report->status !== 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Detail pihak hanya bisa ditambah saat status Menunggu Verifikasi.',
            ], 422);
        }

        try {
            $request->validate([
                'persons'              => 'required|array|min:1',
                'persons.*.role'       => 'required|in:pelaku,korban,saksi',
                'persons.*.student_id' => 'nullable|exists:students,id',
                'persons.*.name_manual'=> 'nullable|string|max:255',
                'persons.*.notes'      => 'nullable|string|max:1000',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($request->persons as $person) {
                // Wajib salah satu: student_id atau name_manual
                if (empty($person['student_id']) && empty($person['name_manual'])) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Setiap pihak harus memiliki siswa terpilih atau nama manual.',
                    ], 422);
                }

                ReportPerson::create([
                    'report_id'   => $report->id,
                    'role'        => $person['role'],
                    'student_id'  => $person['student_id'] ?? null,
                    'name_manual' => $person['name_manual'] ?? null,
                    'notes'       => $person['notes'] ?? null,
                ]);
            }

            // Log penambahan pihak
            $roles = collect($request->persons)->pluck('role')->unique()->implode(', ');
            $report->logActivity(
                "Detail pihak ditambahkan: {$roles}.",
                null, null, null, $adminId, 'admin'
            );

            // Auto-transisi ke 'diproses' jika pelaku & korban sudah lengkap
            if ($report->fresh()->hasRequiredPersons()) {
                $oldStatus = $report->status;
                $report->update([
                    'status'     => 'diproses',
                    'handled_by' => $adminId,
                    'handled_at' => now(),
                ]);
                $report->logActivity(
                    'Status otomatis berubah ke Sedang Diproses setelah detail pihak dilengkapi.',
                    $oldStatus, 'diproses', null, $adminId, 'admin'
                );
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data pihak.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pihak berhasil disimpan.',
            'data'    => $report->fresh()->load('persons.student'),
        ]);
    }

    /**
     * DELETE /api/admin/reports/{reportId}/persons/{personId}
     * Hapus satu entri pelaku/korban/saksi.
     * Jika setelah dihapus pelaku/korban tidak lagi lengkap → rollback ke 'menunggu'.
     */
    public function destroyPerson(int $reportId, int $personId): JsonResponse
    {
        $report  = Report::findOrFail($reportId);
        $person  = ReportPerson::where('report_id', $report->id)->findOrFail($personId);
        /** @var \App\Models\User $admin */
        $admin   = auth('web')->user();
        $adminId = $admin?->id;

        $roleLabel = $person->roleLabel();
        $person->delete();

        $report->logActivity("Data {$roleLabel} dihapus.", null, null, null, $adminId, 'admin');

        // Rollback ke 'menunggu' jika pelaku atau korban tidak lagi ada
        if ($report->status === 'diproses' && ! $report->fresh()->hasRequiredPersons()) {
            $report->update(['status' => 'menunggu']);
            $report->logActivity(
                'Status kembali ke Menunggu Verifikasi karena data pihak tidak lengkap.',
                'diproses', 'menunggu', null, $adminId, 'admin'
            );
        }

        return response()->json([
            'success' => true,
            'message' => "Data {$roleLabel} berhasil dihapus.",
        ]);
    }
    public function getGrades(): JsonResponse
    {
        // Mengambil kombinasi grade dan major yang unik dari tabel students
        $grades = Student::select('grade', 'major')
            ->whereNotNull('grade')
            ->distinct()
            ->get()
            ->map(fn($s) => trim("{$s->grade} {$s->major}")) // GUNAKAN -> BUKAN .
            ->filter()
            ->values();

        return response()->json(['success' => true, 'data' => $grades]);
    }
    public function storeDetail(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->input('code', '')));

        if (empty($code)) {
            return response()->json(['success' => false, 'message' => 'Kode tiket wajib diisi.'], 422);
        }

        $report = Report::where('ticket_code', $code)->first();

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Kode tiket tidak ditemukan.'], 404);
        }

        if (!in_array($report->status, ['masuk', 'menunggu'])) {
            return response()->json(['success' => false, 'message' => 'Detail hanya bisa diisi saat status Masuk atau Menunggu Verifikasi.'], 422);
        }

        try {
            $request->validate([
                'tanggal' => 'required|date',
                'jam'     => 'nullable|string|max:10',
                'lokasi'  => 'required|string|max:255',
                'pelaku'  => 'required|array|min:1',
                'korban'  => 'required|array|min:1',
                'saksi'   => 'nullable|array',
                'pelaku.*.nama'    => 'required|string|max:255',
                'korban.*.nama'    => 'required|string|max:255',
                'saksi.*.nama'     => 'nullable|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $oldStatus = $report->status;
            // Simpan waktu & lokasi kejadian
            $report->update([
                'incident_date'     => $request->tanggal,
                'incident_time'     => $request->jam ?? null,
                'incident_location' => $request->lokasi,
                'status'            => 'menunggu', // pastikan minimal menunggu
            ]);

            // Hapus persons lama jika ada (replace)
            $report->persons()->delete();

            // Simpan pelaku
            foreach ($request->pelaku as $p) {
                if (empty($p['nama'])) continue;
                $studentId = $this->findStudentId($p);
                ReportPerson::create([
                    'report_id'    => $report->id,
                    'role'         => 'pelaku',        // atau korban/saksi
                    'student_id'   => $studentId,
                    'name_manual'  => $studentId ? null : $p['nama'],
                    'grade_manual' => $studentId ? null : ($p['kelas']   ?? null),  // ← tambah
                    'major_manual' => $studentId ? null : ($p['jurusan'] ?? null),  // ← tambah
                    'notes'        => $p['catatan'] ?? null,
                ]);
            }

            // Simpan korban
            foreach ($request->korban as $p) {
                if (empty($p['nama'])) continue;
                $studentId = $this->findStudentId($p);
                ReportPerson::create([
                    'report_id'   => $report->id,
                    'role'        => 'korban',
                    'student_id'  => $studentId,
                    'name_manual' => $studentId ? null : $p['nama'],
                    'notes'       => $p['catatan'] ?? null,
                ]);
            }

            // Simpan saksi (opsional)
            if ($request->saksi) {
                foreach ($request->saksi as $p) {
                    if (empty($p['nama'])) continue;
                    $studentId = $this->findStudentId($p);
                    ReportPerson::create([
                        'report_id'    => $report->id,
                        'role'         => 'saksi',
                        'student_id'   => $studentId,
                        'name_manual'  => $studentId ? null : $p['nama'],
                        'grade_manual' => $studentId ? null : ($p['kelas']   ?? null), // ← TAMBAH
                        'major_manual' => $studentId ? null : ($p['jurusan'] ?? null), // ← TAMBAH
                        'notes'        => $p['catatan'] ?? null,
                    ]);
                }
            }
            // Log aktivitas
            // Log aktivitas pelapor mengisi detail
            $report->logActivity(
                'Pelapor melengkapi detail kejadian (waktu, lokasi, dan pihak terlibat).',
                $oldStatus,
                'menunggu',
                null,
                null,
                'pelapor'
            );

            // Langsung ubah status ke diproses dalam satu update
            $report->update([
                'status'     => 'diproses',
                'handled_at' => now(),
            ]);

            // Refresh model agar status terbaru terbaca
            $report->refresh();

            $report->logActivity(
                'Laporan telah diverifikasi dan akan segera ditindaklanjuti oleh petugas sekolah.',
                'menunggu',
                'diproses',
                null,
                null,
                'sistem'
            );
            $this->notifyAllUsers(
                'detail_lengkap',
                'Detail Laporan Dilengkapi',
                "Pelapor telah melengkapi detail laporan #{$report->ticket_code}. Laporan siap diverifikasi.",
                'check',
                'blue',
                '/menunggu-verifikasi?open=' . $report->id
            );

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('storeDetail error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan detail: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail berhasil disimpan. Laporan sedang diproses.',
            'data'    => $report->fresh()->load('persons.student'),
        ]);
    }
    public function storeFollowUp(Request $request, int $id): JsonResponse
    {
        $report  = Report::findOrFail($id);
        $admin   = auth('web')->user();
        $adminId = $admin?->id;

        if ($report->status !== 'diproses') {
            return response()->json([
                'success' => false,
                'message' => 'Tindak lanjut hanya bisa diisi saat laporan berstatus Sedang Diproses.',
            ], 422);
        }

        try {
            $request->validate([
                'discipline_action_id' => 'required|exists:discipline_actions,id',
                'tanggal_pelaksanaan'  => 'required|date',
                'deskripsi'            => 'required|string|min:10|max:5000',
                'catatan_tambahan'     => 'nullable|string|max:2000',
                'files'                => 'nullable|array|max:5',
                'files.*'              => 'file|max:51200',
            ], [
                'discipline_action_id.required' => 'Jenis tindakan wajib dipilih.',
                'discipline_action_id.exists'   => 'Jenis tindakan tidak valid.',
                'tanggal_pelaksanaan.required'  => 'Tanggal pelaksanaan wajib diisi.',
                'deskripsi.required'            => 'Deskripsi tindakan wajib diisi.',
                'deskripsi.min'                 => 'Deskripsi minimal 10 karakter.',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }

        $allowedMime = [
            'image/jpeg','image/jpg','image/png','image/webp',
            'application/pdf',
            'video/mp4','video/quicktime','video/x-msvideo','video/webm',
        ];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (!in_array($file->getMimeType(), $allowedMime)) {
                    return response()->json([
                        'success' => false,
                        'message' => "File '{$file->getClientOriginalName()}' tidak didukung.",
                    ], 422);
                }
            }
        }

        $action = DisciplineAction::findOrFail($request->discipline_action_id);

        DB::beginTransaction();
        try {
            $followUp = ReportFollowUp::updateOrCreate(
                ['report_id' => $report->id],
                [
                    'discipline_action_id' => $action->id,
                    'jenis_tindakan'       => $action->name,
                    'tanggal_pelaksanaan'  => $request->tanggal_pelaksanaan,
                    'deskripsi'            => $request->deskripsi,
                    'catatan_tambahan'     => $request->catatan_tambahan ?? null,
                    'pelaksana'            => $action->executor ?? null,
                    'keterlibatan_ortu'    => $action->parent_involvement ?? 'tidak',
                ]
            );

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $stored = $file->store("follow-ups/{$report->id}", 'public');
                    FollowUpFile::create([
                        'follow_up_id'  => $followUp->id,
                        'original_name' => $file->getClientOriginalName(),
                        'stored_name'   => $stored,
                        'mime_type'     => $file->getMimeType(),
                        'size'          => $file->getSize(),
                    ]);
                }
            }

            // ✅ TAMBAH INI — ubah status ke selesai
            $report->update([
                'status'     => 'selesai',
                'handled_by' => $adminId,
                'handled_at' => now(),
            ]);

            $report->logActivity(
                "Tindak lanjut disimpan: {$action->name} dijadwalkan pada {$request->tanggal_pelaksanaan}.",
                'diproses',
                'selesai',
                null,
                $adminId,
                'admin'
            );

            $this->notifyAllUsers(
                'tindak_lanjut',
                'Tindak Lanjut Disimpan',
                "Laporan #{$report->ticket_code} telah ditindaklanjuti dengan: {$action->name} oleh {$admin->nama}.",
                'check',
                'green',
                '/laporan-selesai?open=' . $report->id
            );

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('storeFollowUp: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan tindak lanjut.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tindak lanjut berhasil disimpan.',
            'data'    => $followUp->fresh(),
        ]);
    }

    public function storeFeedback(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->input('code', '')));

        if (empty($code)) {
            return response()->json(['success' => false, 'message' => 'Kode tiket wajib diisi.'], 422);
        }

        $report = Report::where('ticket_code', $code)->first();

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Kode tiket tidak ditemukan.'], 404);
        }

        if (!in_array($report->status, ['selesai', 'ditolak'])) {
            return response()->json(['success' => false, 'message' => 'Feedback hanya bisa dikirim untuk laporan yang sudah selesai atau ditolak.'], 422);
        }

        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'pesan'  => 'nullable|string|max:1000',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }

        // Cek apakah sudah pernah submit feedback
        if ($report->feedback()->exists()) {
            return response()->json(['success' => false, 'message' => 'Anda sudah mengirim penilaian untuk laporan ini.'], 422);
        }

        $report->feedback()->create([
            'rating' => $request->rating,
            'pesan'  => $request->pesan ?? null,
        ]);

        // ── TAMBAHKAN INI ──────────────────────────────────────────
        $statusUrl = $report->status === 'selesai'
            ? '/laporan-selesai'
            : '/laporan-ditolak';

        $this->notifyAllUsers(
            'feedback',
            'Feedback Diterima dari Pelapor',
            "Pelapor memberikan penilaian {$request->rating}/5 bintang untuk laporan #{$report->ticket_code}.",
            'chat',
            'blue',
            $statusUrl . '?open=' . $report->id
        );
        // ── SAMPAI SINI ────────────────────────────────────────────

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Penilaian Anda telah dikirim.',
        ]);
    }

    public function reportCounts(): JsonResponse
    {
        return response()->json([
            'masuk'      => Report::where('status', 'masuk')->count(),
            'menunggu'   => Report::where('status', 'menunggu')->count(),
            'diproses'   => Report::where('status', 'diproses')->count(),
            'selesai'    => Report::where('status', 'selesai')->count(),
            'ditolak'    => Report::where('status', 'ditolak')->count(),
        ]);
    }

    /**
     * Cari student_id berdasarkan nama atau student_id yang dikirim dari JS.
     */
    private function findStudentId(array $person): ?int
    {
        // Kalau JS sudah kirim student_id langsung
        if (!empty($person['student_id'])) {
            return (int) $person['student_id'];
        }

        // Coba cari by nama
        $student = Student::where('fullname', $person['nama'])->first();
        return $student?->id;
    }
}