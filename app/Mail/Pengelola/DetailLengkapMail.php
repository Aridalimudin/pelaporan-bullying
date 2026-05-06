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

class DetailLengkapMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Report $report,
        public User   $admin,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . $this->report->ticket_code . '] Detail Laporan Dilengkapi — Segera Beri Tindakan',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengelola.detail-lengkap',
            with: [
                'report' => $this->report,
                'admin'  => $this->admin,
            ],
        );
    }
}