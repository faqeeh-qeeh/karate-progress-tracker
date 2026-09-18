<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'reset_token',
        'otp_expires_at',
        'reset_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'otp_expires_at' => 'datetime',
            'reset_expires_at' => 'datetime',
        ];
    }

    /**
     * Cek apakah kode OTP masih berlaku (belum melewati batas waktu 5 menit).
     */
    public function isOtpValid(): bool
    {
        return $this->otp_expires_at && $this->otp_expires_at->isFuture();
    }

    /**
     * Cek apakah reset token masih berlaku (belum melewati batas waktu 2 jam).
     */
    public function isResetTokenValid(): bool
    {
        return $this->reset_token && $this->reset_expires_at && $this->reset_expires_at->isFuture();
    }
}
