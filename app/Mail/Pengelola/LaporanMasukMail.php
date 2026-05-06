<?php

namespace App\Mail\Pengelola;

use App\Models\Report;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LaporanMasukMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Report $report,
        public User   $admin,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . $this->report->ticket_code . '] Laporan Baru Masuk — Segera Tinjau',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengelola.laporan-masuk',
            with: [
                'report' => $this->report,
                'admin'  => $this->admin,
            ],
        );
    }
}