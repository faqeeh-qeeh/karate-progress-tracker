<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun & Pengaturan Kata Sandi</title>
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
        img {
            border: 0;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f1f5f9;
            padding: 40px 0;
        }
        .main-container {
            max-width: 600px;
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
            padding: 32px 36px 24px;
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
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            margin-bottom: 16px;
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
            margin: 0 0 16px;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 20px;
            margin: 20px 0;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            padding: 6px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .info-label {
            color: #64748b;
            font-weight: 500;
        }
        .info-value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
        }
        .steps-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 18px 20px;
            margin: 24px 0;
        }
        .steps-title {
            font-size: 13px;
            font-weight: 700;
            color: #166534;
            margin: 0 0 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .steps-list {
            margin: 0;
            padding-left: 20px;
            font-size: 13px;
            color: #15803d;
            line-height: 1.6;
        }
        .btn-wrapper {
            text-align: center;
            margin: 32px 0 24px;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #1d4ed8 0%, #0284c7 100%);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.25);
            letter-spacing: 0.2px;
        }
        .expiry-note {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin: 0 0 24px;
        }
        .fallback-box {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 36px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
            word-break: break-all;
        }
        .fallback-box a {
            color: #1d4ed8;
            text-decoration: underline;
        }
        .footer {
            padding: 24px 36px 32px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
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
                <div class="badge">
                    Role: {{ $roleName }}
                </div>

                <h2 class="greeting">Halo, {{ $user->name }}! 👋</h2>

                <p class="paragraph">
                    Akun Anda telah berhasil didaftarkan oleh Administrator ke dalam sistem <strong>Karate Progress Tracker POLINDRA</strong>.
                </p>

                <!-- User Info Box -->
                <div class="info-card">
                    <table width="100%">
                        <tr>
                            <td class="info-label" style="padding: 4px 0;">Nama Lengkap:</td>
                            <td class="info-value" style="padding: 4px 0;">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label" style="padding: 4px 0;">Email Terdaftar:</td>
                            <td class="info-value" style="padding: 4px 0;">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="info-label" style="padding: 4px 0;">Hak Akses / Peran:</td>
                            <td class="info-value" style="padding: 4px 0;">{{ $roleName }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Steps Guide -->
                <div class="steps-box">
                    <div class="steps-title">📌 Langkah Mudah Aktivasi Akun Anda:</div>
                    <ol class="steps-list">
                        <li>Klik tombol <strong>"Konfirmasi Email & Atur Kata Sandi"</strong> di bawah.</li>
                        <li>Buat kata sandi baru yang kuat untuk mengamankan akun Anda.</li>
                        <li>Setelah kata sandi tersimpan, akun Anda langsung aktif dan siap digunakan untuk login ke sistem.</li>
                    </ol>
                </div>

                <!-- CTA Button -->
                <div class="btn-wrapper">
                    <a href="{{ $activationUrl }}" class="btn-primary" target="_blank">
                        Konfirmasi Email & Atur Kata Sandi &rarr;
                    </a>
                </div>

                <div class="expiry-note">
                    ⏳ Tautan di atas berlaku selama <strong>{{ $expiresInHours }} jam</strong> sejak email ini dikirimkan.
                </div>
            </div>

            <!-- Fallback URL Section -->
            <div class="fallback-box">
                Jika tombol di atas tidak dapat diklik, salin dan tempel tautan berikut ke browser web Anda:<br>
                <a href="{{ $activationUrl }}" target="_blank">{{ $activationUrl }}</a>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>Email ini dikirimkan secara otomatis oleh Sistem Karate Progress Tracker POLINDRA.</p>
                <p>Jika Anda merasa tidak pernah didaftarkan ke sistem ini, abaikan pesan ini.</p>
                <p>&copy; {{ date('Y') }} Karate Polindra. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
