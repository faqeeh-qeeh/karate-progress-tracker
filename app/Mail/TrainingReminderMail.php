<?php

namespace App\Mail;

use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrainingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public TrainingSchedule $schedule;
    public User $recipient;
    public string $recipientRole; // 'senpai' atau 'kohai'

    /**
     * Create a new message instance.
     */
    public function __construct(TrainingSchedule $schedule, User $recipient, string $recipientRole)
    {
        $this->schedule      = $schedule;
        $this->recipient     = $recipient;
        $this->recipientRole = strtolower($recipientRole);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🥋 Pengingat Jadwal Latihan: {$this->schedule->title} - Karate Polindra",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->recipientRole === 'senpai'
            ? 'emails.training-reminder-senpai'
            : 'emails.training-reminder-kohai';

        return new Content(
            view: $view,
            with: [
                'schedule'  => $this->schedule,
                'recipient' => $this->recipient,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
