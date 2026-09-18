<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class AccountActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $activationUrl;
    public int $expiresInHours;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, int $expiresInHours = 72)
    {
        $this->user = $user;
        $this->expiresInHours = $expiresInHours;

        // Buat temporary signed URL untuk aktivasi dan pengaturan password
        $this->activationUrl = URL::temporarySignedRoute(
            'account.activate',
            now()->addHours($expiresInHours),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $roleName = $this->user->role?->nama ?? 'Pengguna';

        return new Envelope(
            subject: "Aktivasi Akun & Pengaturan Kata Sandi {$roleName} - Karate Polindra",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.account-activation',
            with: [
                'user' => $this->user,
                'activationUrl' => $this->activationUrl,
                'expiresInHours' => $this->expiresInHours,
                'roleName' => $this->user->role?->nama ?? 'Pengguna',
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
