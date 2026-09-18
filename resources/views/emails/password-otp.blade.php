<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Kata Sandi</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1e293b;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        td {
            padding: 0;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f1f5f9;
            padding: 40px 0;
        }
        .main-container {
            max-width: 560px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
        .header-bar {
            height: 6px;
            background: linear-gradient(90deg, #0f172a 0%, #1d4ed8 50%, #e11d48 100%);
        }
        .header {
            padding: 32px 36px 20px;
            text-align: center;
            background-color: #ffffff;
        }
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin: 0;
        }
        .logo-text span {
            color: #e11d48;
        }
        .subtitle {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
            font-weight: 500;
        }
        .content {
            padding: 0 36px 36px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 12px;
        }
        .paragraph {
            font-size: 14px;
            line-height: 1.6;
            color: #475569;
            margin: 0 0 20px;
        }
        .otp-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 24px 20px;
            text-align: center;
            margin: 24px 0;
        }
        .otp-label {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        .otp-code {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #1d4ed8;
            margin: 0;
            display: inline-block;
        }
        .otp-expiry {
            font-size: 12px;
            color: #dc2626;
            font-weight: 600;
            margin-top: 8px;
        }
        .warning-box {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 12px;
            color: #991b1b;
            line-height: 1.5;
            margin: 20px 0 0;
        }
        .footer {
            border-top: 1px solid #e2e8f0;
            padding: 24px 36px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            background-color: #fafafa;
        }
        .footer p {
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main-container">
            <!-- Top Gradient Bar -->
            <div class="header-bar"></div>

            <!-- Header -->
            <div class="header">
                <h1 class="logo-text">KARATE<span>POLINDRA</span></h1>
                <div class="subtitle">Sistem Informasi & Track Progress Karate Politeknik Negeri Indramayu</div>
            </div>

            <!-- Content Area -->
            <div class="content">
                <h2 class="greeting">Halo, {{ $user->name }}! 🔐</h2>

                <p class="paragraph">
                    Kami menerima permintaan untuk mereset kata sandi akun Anda di <strong>Karate Progress Tracker POLINDRA</strong>. Silakan gunakan kode verifikasi (OTP) berikut untuk melanjutkan proses pembuatan kata sandi baru:
                </p>

                <!-- OTP Code Highlight Box -->
                <div class="otp-box">
                    <div class="otp-label">Kode Verifikasi Anda</div>
                    <div class="otp-code">{{ $otp }}</div>
                    <div class="otp-expiry">⏳ Berlaku selama {{ $expiresInMinutes }} menit</div>
                </div>

                <p class="paragraph" style="font-size: 13px; margin-bottom: 0;">
                    Masukkan 6 digit kode di atas pada halaman verifikasi di browser Anda untuk mengatur kata sandi baru.
                </p>

                <!-- Security Alert -->
                <div class="warning-box">
                    ⚠️ <strong>Penting:</strong> Jangan berikan kode OTP ini kepada siapa pun, termasuk pihak yang mengatasnamakan pengurus dojo atau admin. Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini dan akun Anda akan tetap aman.
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>Email ini dikirimkan secara otomatis oleh Sistem Karate Progress Tracker POLINDRA.</p>
                <p>&copy; {{ date('Y') }} Karate Polindra. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
