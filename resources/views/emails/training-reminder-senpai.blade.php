<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Jadwal Latihan Karate</title>
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
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
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
            padding: 8px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .info-label {
            color: #64748b;
            font-weight: 500;
            width: 40%;
        }
        .info-value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
            width: 60%;
        }
        .type-tag {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }
        .type-rutin {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }
        .type-tambahan {
            background-color: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }
        .steps-box {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 18px 20px;
            margin: 24px 0;
        }
        .steps-title {
            font-size: 13px;
            font-weight: 700;
            color: #1e3a8a;
            margin: 0 0 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .steps-list {
            margin: 0;
            padding-left: 20px;
            font-size: 13px;
            color: #1d4ed8;
            line-height: 1.6;
        }
        .btn-wrapper {
            text-align: center;
            margin: 28px 0 16px;
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
        .footer {
            padding: 24px 36px 32px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            background-color: #f8fafc;
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
                    🥋 Khusus Senpai (Instruktur / Pelatih)
                </div>

                <h2 class="greeting">Halo, Senpai {{ $recipient->name }}! 👋</h2>

                <p class="paragraph">
                    Pemberitahuan pengingat jadwal latihan dojo mendatang yang telah dijadwalkan oleh Administrator pada sistem <strong>Karate Progress Tracker</strong>.
                </p>

                <!-- Schedule Info Card -->
                <div class="info-card">
                    <table width="100%">
                        <tr>
                            <td class="info-label" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">Nama Jadwal:</td>
                            <td class="info-value" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">{{ $schedule->title }}</td>
                        </tr>
                        <tr>
                            <td class="info-label" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">Jenis Latihan:</td>
                            <td class="info-value" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">
                                <span class="type-tag {{ $schedule->type === 'rutin' ? 'type-rutin' : 'type-tambahan' }}">
                                    {{ $schedule->type_label }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">Tanggal Latihan:</td>
                            <td class="info-value" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0; color: #1d4ed8; font-size: 14px;">
                                📅 {{ $schedule->upcoming_date_formatted }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">Waktu Latihan:</td>
                            <td class="info-value" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0; font-family: monospace;">
                                ⏰ {{ $schedule->time_range }} WIB
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">Lokasi:</td>
                            <td class="info-value" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">
                                📍 {{ $schedule->location_label }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">Detail Tempat:</td>
                            <td class="info-value" style="padding: 7px 0; border-bottom: 1px dashed #e2e8f0;">
                                {{ $schedule->location_detail ?? 'Dojo Utama Polindra' }}
                            </td>
                        </tr>
                        @if($schedule->notes)
                        <tr>
                            <td class="info-label" style="padding: 7px 0;">Catatan Tambahan:</td>
                            <td class="info-value" style="padding: 7px 0; font-weight: normal; color: #475569;">
                                {{ $schedule->notes }}
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>

                <!-- Instructor Checklist Box -->
                <div class="steps-box">
                    <div class="steps-title">📋 Catatan & Arahan untuk Pelatih (Senpai):</div>
                    <ol class="steps-list">
                        <li>Pastikan materi kurikulum latihan (Kihon, Kata, atau Kumite) sudah dipersiapkan.</li>
                        <li>Buka dan aktifkan sesi <strong>Presensi QR Code</strong> melalui dashboard Senpai saat sesi latihan dimulai.</li>
                        <li>Pastikan seluruh Kohai mematuhi tata tertib dan disiplin selama berada di dojo.</li>
                    </ol>
                </div>

                <!-- Google Maps Link Button (if available) -->
                @if($schedule->maps_url)
                <div class="btn-wrapper">
                    <a href="{{ $schedule->maps_url }}" class="btn-primary" target="_blank">
                        📍 Buka Lokasi Latihan di Google Maps &rarr;
                    </a>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>Email pengingat otomatis ini dikirim oleh Sistem Karate Progress Tracker POLINDRA.</p>
                <p>Osu! Tetap semangat membimbing karateka dojo.</p>
                <p>&copy; {{ date('Y') }} Karate Polindra. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
