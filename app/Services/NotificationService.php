<?php
namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Kirim notifikasi web ke satu atau banyak user.
     * $recipients: User | Collection | array of user ids
     */
    public static function send($recipients, array $data): void
    {
        $users = collect($recipients instanceof User ? [$recipients] : $recipients)
            ->map(fn($u) => $u instanceof User ? $u->id : $u)
            ->filter()
            ->unique()
            ->values();

        if ($users->isEmpty()) return;

        $now  = now();
        $rows = $users->map(fn($uid) => array_merge($data, [
            'user_id'    => $uid,
            'created_at' => $now,
            'updated_at' => $now,
        ]))->toArray();

        Notification::insert($rows);
    }

    // ── Helper per jenis notifikasi ──────────────────────

    public static function laporanMasuk($laporan, $recipients): void
    {
        self::send($recipients, [
            'type'         => 'laporan_masuk',
            'title'        => 'Laporan baru masuk',
            'body'         => "Laporan {$laporan->kode} dari {$laporan->pelapor_nama} telah masuk.",
            'icon'         => 'file',
            'color'        => 'green',
            'related_id'   => $laporan->id,
            'related_type' => 'laporan',
            'url'          => "/admin/laporan/{$laporan->id}",
        ]);
    }

    public static function reminderLaporan($laporan, $recipients): void
    {
        self::send($recipients, [
            'type'         => 'reminder_laporan',
            'title'        => 'Pengingat: laporan belum diproses',
            'body'         => "Laporan {$laporan->kode} belum diproses lebih dari 24 jam.",
            'icon'         => 'clock',
            'color'        => 'yellow',
            'related_id'   => $laporan->id,
            'related_type' => 'laporan',
            'url'          => "/admin/laporan/{$laporan->id}",
        ]);
    }

    public static function laporanDisetujui($laporan, User $pelapor): void
    {
        self::send($pelapor, [
            'type'         => 'laporan_disetujui',
            'title'        => 'Laporan kamu disetujui',
            'body'         => "Laporan {$laporan->kode} telah disetujui dan sedang diproses.",
            'icon'         => 'check',
            'color'        => 'blue',
            'related_id'   => $laporan->id,
            'related_type' => 'laporan',
            'url'          => "/laporan/{$laporan->id}",
        ]);
    }

    public static function laporanDitolak($laporan, User $pelapor, string $alasan): void
    {
        self::send($pelapor, [
            'type'         => 'laporan_ditolak',
            'title'        => 'Laporan kamu ditolak',
            'body'         => "Laporan {$laporan->kode} ditolak. Alasan: {$alasan}",
            'icon'         => 'x',
            'color'        => 'red',
            'related_id'   => $laporan->id,
            'related_type' => 'laporan',
            'url'          => "/laporan/{$laporan->id}",
        ]);
    }

    public static function laporanSelesai($laporan, User $pelapor): void
    {
        self::send($pelapor, [
            'type'         => 'laporan_selesai',
            'title'        => 'Laporan selesai ditangani',
            'body'         => "Laporan {$laporan->kode} telah selesai ditangani.",
            'icon'         => 'check',
            'color'        => 'green',
            'related_id'   => $laporan->id,
            'related_type' => 'laporan',
            'url'          => "/laporan/{$laporan->id}",
        ]);
    }

    public static function feedbackMasuk($laporan, $recipients): void
    {
        self::send($recipients, [
            'type'         => 'feedback_masuk',
            'title'        => 'Feedback baru dari pelapor',
            'body'         => "Ada feedback baru pada laporan {$laporan->kode}.",
            'icon'         => 'chat',
            'color'        => 'blue',
            'related_id'   => $laporan->id,
            'related_type' => 'laporan',
            'url'          => "/admin/laporan/{$laporan->id}",
        ]);
    }

    public static function bkApprove($laporan, string $namaBk, $recipients): void
    {
        self::send($recipients, [
            'type'         => 'bk_approve',
            'title'        => 'Laporan disetujui BK',
            'body'         => "{$namaBk} menyetujui laporan {$laporan->kode}.",
            'icon'         => 'shield',
            'color'        => 'green',
            'related_id'   => $laporan->id,
            'related_type' => 'laporan',
            'url'          => "/admin/laporan/{$laporan->id}",
        ]);
    }

    public static function bkSelesai($laporan, string $namaBk, $recipients): void
    {
        self::send($recipients, [
            'type'         => 'bk_selesai',
            'title'        => 'Laporan diselesaikan BK',
            'body'         => "{$namaBk} menyelesaikan penanganan laporan {$laporan->kode}.",
            'icon'         => 'check',
            'color'        => 'green',
            'related_id'   => $laporan->id,
            'related_type' => 'laporan',
            'url'          => "/admin/laporan/{$laporan->id}",
        ]);
    }
}