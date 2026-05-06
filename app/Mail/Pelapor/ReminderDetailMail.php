<?php

namespace App\Mail\Pelapor;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReminderDetailMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Report $report) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . $this->report->ticket_code . '] Pengingat: Segera Lengkapi Detail Laporan',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pelapor.reminder-detail',
            with: ['report' => $this->report],
        );
    }
}