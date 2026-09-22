<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="UKM Karate Politeknik Negeri Indramayu — Unit Kegiatan Mahasiswa Karate resmi Polindra. Latihan rutin, prestasi kejuaraan, dan sistem KARATER untuk pengelolaan anggota.">
  <meta name="keywords" content="UKM Karate Polindra, Karate Politeknik Negeri Indramayu, KARATER, karate kampus indramayu">
  <meta property="og:title" content="UKM Karate Polindra">
  <meta property="og:description" content="Unit Kegiatan Mahasiswa Karate resmi Politeknik Negeri Indramayu">
  <meta property="og:type" content="website">
  <title>UKM Karate Polindra — Satu Jiwa, Satu Tekad</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

{{-- ===================================================
     NAVBAR
     =================================================== --}}
<nav id="navbar">
  <div class="nav-inner">
    <a href="#hero" class="nav-logo" id="nav-logo-link">
      <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}" alt="Logo UKM Karate Polindra">
      <div class="nav-logo-text">
        <span class="name">UKM KARATE</span>
        <span class="sub">Politeknik Negeri Indramayu</span>
      </div>
    </a>

    <ul class="nav-links" id="nav-links">
      <li><a href="#about">Tentang</a></li>
      <li><a href="#achievements">Prestasi</a></li>
      <li><a href="#schedule">Jadwal</a></li>
      <li><a href="#gallery">Galeri</a></li>
      <li><a href="#join">Bergabung</a></li>
    </ul>

    <div class="nav-cta">
      <a href="{{ route('login') }}" class="btn-ghost" id="nav-login-btn">Masuk</a>
      <a href="{{ route('register') }}" class="btn-primary" id="nav-register-btn">Daftar Sekarang</a>
      <button class="nav-hamburger" id="hamburger-btn" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>

  {{-- Mobile menu --}}
  <div class="nav-mobile" id="nav-mobile">
    <a href="#about">Tentang UKM</a>
    <a href="#achievements">Prestasi</a>
    <a href="#schedule">Jadwal Latihan</a>
    <a href="#gallery">Galeri</a>
    <a href="#join">Cara Bergabung</a>
    <a href="{{ route('login') }}" class="btn-ghost" style="text-align:center;margin-top:8px;" id="mobile-login-btn">Masuk ke Sistem</a>
    <a href="{{ route('register') }}" class="btn-primary" id="mobile-register-btn">Daftar Sekarang</a>
  </div>
</nav>


{{-- ===================================================
     HERO
     =================================================== --}}
<section id="hero">
  {{-- Background: gunakan hero-banner.jpg jika tersedia --}}
  <div class="hero-img-fallback"></div>
  @if(file_exists(public_path('images/landing/hero-banner.jpg')))
    <img
      src="{{ asset('images/landing/hero-banner.jpg') }}"
      alt="UKM Karate Polindra"
      class="hero-img"
      loading="eager"
    >
  @endif
  <div class="hero-bg"></div>
  <div class="hero-accent-line"></div>

  <div class="hero-content container">
    <div class="hero-eyebrow">
      <div class="hero-eyebrow-line"></div>
      <span class="hero-eyebrow-text">Politeknik Negeri Indramayu</span>
    </div>

    <h1 class="hero-title">
      <span>UKM</span>
      <span class="line-red">KARATE</span>
      <span class="line-outline">POLINDRA</span>
    </h1>

    <p class="hero-desc">
      Membentuk atlet berkarakter, berprestasi, dan berdisiplin tinggi.
      Bersama kami, karate bukan sekadar olahraga — ia adalah cara hidup.
    </p>

    <div class="hero-actions">
      <a href="#join" class="btn-hero-primary" id="hero-join-btn">
        Bergabung Sekarang
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
          <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
      <a href="{{ route('login') }}" class="btn-hero-secondary" id="hero-system-btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
          <rect x="2" y="2" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/>
          <path d="M8 5v3l2 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Masuk ke Sistem KARATER
      </a>
    </div>
  </div>

  {{-- Stats bar --}}
  <div class="hero-stats">
    <div class="hero-stats-inner">
      <div class="hero-stat-item">
        <div class="hero-stat-num" data-count="2016">2016</div>
        <div class="hero-stat-label">Tahun Berdiri</div>
      </div>
      <div class="hero-stat-item">
        <div class="hero-stat-num"><span id="count-members">80</span><span>+</span></div>
        <div class="hero-stat-label">Anggota Aktif</div>
      </div>
      <div class="hero-stat-item">
        <div class="hero-stat-num"><span id="count-medals">50</span><span>+</span></div>
        <div class="hero-stat-label">Medali Kejuaraan</div>
      </div>
      <div class="hero-stat-item">
        <div class="hero-stat-num"><span id="count-events">20</span><span>+</span></div>
        <div class="hero-stat-label">Event Diikuti</div>
      </div>
    </div>
  </div>
</section>


{{-- ===================================================
     ABOUT
     =================================================== --}}
<section id="about">
  <div class="container">
    <div class="about-grid">
      {{-- Image --}}
      <div class="about-img-wrap reveal">
        @if(file_exists(public_path('images/landing/about-team.jpg')))
          <img
            src="{{ asset('images/landing/about-team.jpg') }}"
            alt="Tim Karate Polindra"
            class="about-img"
          >
        @else
          <div class="about-img-placeholder">
            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="40" cy="28" r="14" stroke="white" stroke-width="1.5"/>
              <path d="M12 72c0-15.464 12.536-28 28-28s28 12.536 28 28" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
        @endif
      </div>

      {{-- Content --}}
      <div class="about-content reveal">
        <div class="section-label">Tentang Kami</div>
        <h2>Disiplin<br>Membentuk<br><em>Juara</em></h2>
        <p>
          UKM Karate Politeknik Negeri Indramayu adalah wadah resmi bagi mahasiswa
          yang ingin mengembangkan kemampuan bela diri karate di lingkungan kampus.
          Kami bernaung di bawah WKF (World Karate Federation) dan aktif mengikuti
          berbagai kejuaraan tingkat regional maupun nasional.
        </p>
        <p>
          Dengan pelatih berpengalaman dan program latihan terstruktur, kami memastikan
          setiap anggota berkembang — baik dalam teknik, mental, maupun karakter.
        </p>

        <div class="about-pillars">
          <div class="about-pillar">
            <div class="about-pillar-icon">⚡</div>
            <div class="about-pillar-title">Kihon</div>
            <div class="about-pillar-desc">Latihan teknik dasar yang konsisten setiap sesi</div>
          </div>
          <div class="about-pillar">
            <div class="about-pillar-icon">🥋</div>
            <div class="about-pillar-title">Kata</div>
            <div class="about-pillar-desc">Rangkaian gerakan terstandar sebagai fondasi seni</div>
          </div>
          <div class="about-pillar">
            <div class="about-pillar-icon">🥊</div>
            <div class="about-pillar-title">Kumite</div>
            <div class="about-pillar-desc">Pertarungan terkontrol untuk mengasah insting & refleks</div>
          </div>
          <div class="about-pillar">
            <div class="about-pillar-icon">🏆</div>
            <div class="about-pillar-title">Kompetisi</div>
            <div class="about-pillar-desc">Mengikuti kejuaraan sebagai uji kemampuan nyata</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ===================================================
     ACHIEVEMENTS
     =================================================== --}}
<section id="achievements">
  <div class="container">
    <div class="achievements-header reveal">
      <div class="section-label" style="justify-content:center;margin:0 auto 16px;">Prestasi</div>
      <h2>Rekam Jejak <span>Kemenangan</span></h2>
    </div>

    <div class="achievements-grid">

      {{-- Card 1 --}}
      <div class="achievement-card featured-card reveal">
        <div class="achievement-medal medal-gold">🥇</div>
        <div class="achievement-event">POMNAS 2024</div>
        <div class="achievement-title">Juara 1 Kata Perorangan Putra</div>
        <div class="achievement-meta">Jakarta · Agustus 2024</div>
      </div>

      {{-- Card 2 --}}
      <div class="achievement-card reveal">
        <div class="achievement-medal medal-silver">🥈</div>
        <div class="achievement-event">Kejurda Jabar 2024</div>
        <div class="achievement-title">Juara 2 Kumite -60kg Putra</div>
        <div class="achievement-meta">Bandung · April 2024</div>
      </div>

      {{-- Card 3 --}}
      <div class="achievement-card reveal">
        <div class="achievement-medal medal-gold">🥇</div>
        <div class="achievement-event">Kejuaraan Politeknik</div>
        <div class="achievement-title">Juara Umum Se-Jawa Barat</div>
        <div class="achievement-meta">Bekasi · November 2023</div>
      </div>

      {{-- Card 4 --}}
      <div class="achievement-card reveal">
        <div class="achievement-medal medal-bronze">🥉</div>
        <div class="achievement-event">Piala Rektor 2023</div>
        <div class="achievement-title">Juara 3 Kata Beregu Putri</div>
        <div class="achievement-meta">Cirebon · Oktober 2023</div>
      </div>

      {{-- Card 5 --}}
      <div class="achievement-card reveal">
        <div class="achievement-medal medal-silver">🥈</div>
        <div class="achievement-event">Forki Cup 2023</div>
        <div class="achievement-title">Juara 2 Kumite -55kg Putri</div>
        <div class="achievement-meta">Indramayu · Maret 2023</div>
      </div>

      {{-- Card 6 --}}
      <div class="achievement-card reveal">
        <div class="achievement-medal medal-gold">🥇</div>
        <div class="achievement-event">Open Championship 2022</div>
        <div class="achievement-title">Juara 1 Kata Beregu Putra</div>
        <div class="achievement-meta">Karawang · Desember 2022</div>
      </div>

    </div>
  </div>
</section>


{{-- ===================================================
     SCHEDULE
     =================================================== --}}
<section id="schedule">
  <div class="container">
    <div class="schedule-grid">
      {{-- Intro --}}
      <div class="schedule-intro reveal">
        <div class="section-label">Latihan Rutin</div>
        <h2>Jadwal <span>Berlatih</span><br>Mingguan</h2>
        <p>
          Latihan terbuka untuk mahasiswa aktif Polindra.
          Pemula sangat dipersilakan — kami mulai dari nol bersama.
        </p>
        <div class="schedule-location">
          <div class="schedule-location-icon">📍</div>
          <div class="schedule-location-text">
            <strong>GOR / Hall Olahraga Polindra</strong>
            Jl. Lohbener Lama No. 08, Indramayu, Jawa Barat
          </div>
        </div>
      </div>

      {{-- Table --}}
      <div class="schedule-table reveal">
        <div class="schedule-row header">
          <span>Hari</span>
          <span>Sesi</span>
          <span>Waktu</span>
          <span>Level</span>
        </div>
        <div class="schedule-row">
          <div class="sched-day">Senin</div>
          <div class="sched-type">
            Kihon & Kata
            <small>Teknik Dasar + Rangkaian</small>
          </div>
          <div class="sched-time">15.30 – 18.00</div>
          <div><span class="sched-badge badge-all">Semua</span></div>
        </div>
        <div class="schedule-row">
          <div class="sched-day">Rabu</div>
          <div class="sched-type">
            Kumite
            <small>Pertarungan & Sparring</small>
          </div>
          <div class="sched-time">15.30 – 18.00</div>
          <div><span class="sched-badge badge-advanced">Lanjut</span></div>
        </div>
        <div class="schedule-row">
          <div class="sched-day">Kamis</div>
          <div class="sched-type">
            Kata Khusus
            <small>Persiapan Kompetisi</small>
          </div>
          <div class="sched-time">15.30 – 17.30</div>
          <div><span class="sched-badge badge-advanced">Lanjut</span></div>
        </div>
        <div class="schedule-row">
          <div class="sched-day">Jumat</div>
          <div class="sched-type">
            Kelas Pemula
            <small>Orientasi & Dasar-Dasar</small>
          </div>
          <div class="sched-time">14.00 – 16.30</div>
          <div><span class="sched-badge badge-beginner">Pemula</span></div>
        </div>
        <div class="schedule-row">
          <div class="sched-day">Sabtu</div>
          <div class="sched-type">
            Latihan Penuh
            <small>Kihon + Kata + Kumite</small>
          </div>
          <div class="sched-time">07.00 – 10.00</div>
          <div><span class="sched-badge badge-all">Semua</span></div>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ===================================================
     GALLERY
     =================================================== --}}
<section id="gallery">
  <div class="container">
    <div class="gallery-header reveal">
      <div>
        <div class="section-label">Galeri</div>
        <h2>Momen <span>Terbaik</span></h2>
      </div>
      <p style="font-size:14px;color:var(--muted);max-width:260px;text-align:right;">
        Setiap latihan, setiap pertandingan — diabadikan.
      </p>
    </div>

    <div class="gallery-grid reveal">
      {{-- Item 1 (large) --}}
      <div class="gallery-item" id="gallery-item-1">
        @if(file_exists(public_path('images/landing/gallery-1.jpg')))
          <img src="{{ asset('images/landing/gallery-1.jpg') }}" alt="Latihan Karate Polindra" loading="lazy">
        @else
          <div class="gallery-placeholder">Foto Latihan</div>
        @endif
        <div class="gallery-item-label"><span>Sesi Latihan</span></div>
      </div>

      {{-- Item 2 --}}
      <div class="gallery-item" id="gallery-item-2">
        @if(file_exists(public_path('images/landing/gallery-2.jpg')))
          <img src="{{ asset('images/landing/gallery-2.jpg') }}" alt="Foto Karate" loading="lazy">
        @else
          <div class="gallery-placeholder">Foto Latihan</div>
        @endif
        <div class="gallery-item-label"><span>Kihon</span></div>
      </div>

      {{-- Item 3 --}}
      <div class="gallery-item" id="gallery-item-3">
        @if(file_exists(public_path('images/landing/gallery-3.jpg')))
          <img src="{{ asset('images/landing/gallery-3.jpg') }}" alt="Kejuaraan Karate" loading="lazy">
        @else
          <div class="gallery-placeholder">Kejuaraan</div>
        @endif
        <div class="gallery-item-label"><span>Kejuaraan</span></div>
      </div>

      {{-- Item 4 --}}
      <div class="gallery-item" id="gallery-item-4">
        @if(file_exists(public_path('images/landing/gallery-4.jpg')))
          <img src="{{ asset('images/landing/gallery-4.jpg') }}" alt="Atlet Podium" loading="lazy">
        @else
          <div class="gallery-placeholder">Podium</div>
        @endif
        <div class="gallery-item-label"><span>Podium</span></div>
      </div>

      {{-- Item 5 --}}
      <div class="gallery-item" id="gallery-item-5">
        @if(file_exists(public_path('images/landing/gallery-5.jpg')))
          <img src="{{ asset('images/landing/gallery-5.jpg') }}" alt="Upacara Kejuaraan" loading="lazy">
        @else
          <div class="gallery-placeholder">Event</div>
        @endif
        <div class="gallery-item-label"><span>Opening Ceremony</span></div>
      </div>
    </div>
  </div>
</section>

{{-- Lightbox --}}
<div id="lightbox" role="dialog" aria-modal="true" aria-label="Lightbox galeri">
  <button id="lightbox-close" aria-label="Tutup">✕</button>
  <img id="lightbox-img" src="" alt="Galeri foto">
</div>


{{-- ===================================================
     HOW TO JOIN
     =================================================== --}}
<section id="join">
  <div class="container">
    <div class="join-header reveal">
      <div class="section-label" style="justify-content:center;margin:0 auto 16px;">Cara Bergabung</div>
      <h2>Mulai <span>Perjalananmu</span></h2>
      <p>
        Tidak perlu pengalaman sebelumnya. Yang diperlukan hanya tekad,
        semangat belajar, dan kemauan untuk terus berlatih.
      </p>
    </div>

    <div class="join-steps">
      <div class="join-step reveal">
        <div class="join-step-num">
          01
          <div class="join-step-icon">📝</div>
        </div>
        <h3>Daftar Akun</h3>
        <p>
          Buat akun di sistem KARATER menggunakan email kampus atau
          Google Polindra kamu. Prosesnya kurang dari 2 menit.
        </p>
      </div>

      <div class="join-step reveal">
        <div class="join-step-num">
          02
          <div class="join-step-icon">✅</div>
        </div>
        <h3>Verifikasi & Aktivasi</h3>
        <p>
          Admin akan memverifikasi data pendaftaranmu dan mengaktifkan
          akun. Kamu akan mendapat notifikasi via email.
        </p>
      </div>

      <div class="join-step reveal">
        <div class="join-step-num">
          03
          <div class="join-step-icon">🥋</div>
        </div>
        <h3>Hadir & Berlatih</h3>
        <p>
          Datang ke sesi latihan, absen via KARATER, dan mulailah
          perjalanan karatemuwa bersama komunitas kami.
        </p>
      </div>
    </div>

    <div class="join-cta reveal">
      <a href="{{ route('register') }}" class="btn-join" id="join-cta-btn">
        <span>Daftar Sekarang</span>
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M3.5 9h11M10 4.5L14.5 9 10 13.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
      <span class="join-note">Atau <a href="{{ route('login') }}">masuk</a> jika sudah punya akun</span>
    </div>
  </div>
</section>


{{-- ===================================================
     FOOTER
     =================================================== --}}
<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="#hero" class="nav-logo" id="footer-logo-link">
          <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}" alt="Logo" style="height:40px;">
          <div class="nav-logo-text">
            <span class="name">UKM KARATE</span>
            <span class="sub">Politeknik Negeri Indramayu</span>
          </div>
        </a>
        <p>
          Unit Kegiatan Mahasiswa Karate Polindra — membentuk generasi
          atlet berkarakter melalui disiplin, teknik, dan semangat juang
          tanpa henti.
        </p>
        <div class="footer-social">
          <a href="#" class="social-link" aria-label="Instagram" id="footer-ig">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
              <rect x="2" y="2" width="20" height="20" rx="5"/>
              <circle cx="12" cy="12" r="5"/>
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>
            </svg>
          </a>
          <a href="#" class="social-link" aria-label="YouTube" id="footer-yt">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
              <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.4a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/>
              <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor" stroke="none"/>
            </svg>
          </a>
          <a href="#" class="social-link" aria-label="TikTok" id="footer-tt">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.87a8.17 8.17 0 0 0 4.78 1.52V7.01a4.85 4.85 0 0 1-1.01-.32z"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Navigasi</h4>
        <ul>
          <li><a href="#about">Tentang UKM</a></li>
          <li><a href="#achievements">Prestasi</a></li>
          <li><a href="#schedule">Jadwal Latihan</a></li>
          <li><a href="#gallery">Galeri</a></li>
          <li><a href="#join">Cara Bergabung</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Sistem KARATER</h4>
        <ul>
          <li><a href="{{ route('login') }}" id="footer-login-link">Masuk ke Sistem</a></li>
          <li><a href="{{ route('register') }}" id="footer-register-link">Daftar Anggota</a></li>
          <li><a href="{{ route('password.request') }}" id="footer-forgot-link">Lupa Password</a></li>
        </ul>

        <h4 style="margin-top:28px;">Kontak</h4>
        <ul>
          <li><a href="mailto:karate@polindra.ac.id">karate@polindra.ac.id</a></li>
          <li><a href="#">Politeknik Negeri Indramayu</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© {{ date('Y') }} UKM Karate Politeknik Negeri Indramayu. Hak cipta dilindungi.</p>
      <div class="footer-system-badge" id="footer-system-badge">
        Didukung KARATER System
      </div>
    </div>
  </div>
</footer>


{{-- ===================================================
     JAVASCRIPT
     =================================================== --}}
<script>
(function() {
  'use strict';

  // ── Navbar scroll behavior ────────────────────────
  const navbar = document.getElementById('navbar');
  let lastScroll = 0;
  window.addEventListener('scroll', () => {
    const y = window.scrollY;
    if (y > 40) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
    lastScroll = y;
  }, { passive: true });

  // ── Hamburger toggle ──────────────────────────────
  const hamburger = document.getElementById('hamburger-btn');
  const mobileMenu = document.getElementById('nav-mobile');
  hamburger.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
    const spans = hamburger.querySelectorAll('span');
    const isOpen = mobileMenu.classList.contains('open');
    if (isOpen) {
      spans[0].style.cssText = 'transform: rotate(45deg) translate(5px, 5px)';
      spans[1].style.opacity = '0';
      spans[2].style.cssText = 'transform: rotate(-45deg) translate(5px, -5px)';
    } else {
      spans.forEach(s => s.style.cssText = '');
    }
  });

  // Close mobile menu on link click
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.classList.remove('open');
      hamburger.querySelectorAll('span').forEach(s => s.style.cssText = '');
    });
  });

  // ── Scroll reveal ─────────────────────────────────
  const revealEls = document.querySelectorAll('.reveal');
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        // Stagger siblings
        const siblings = entry.target.parentElement.querySelectorAll('.reveal');
        let delay = 0;
        siblings.forEach((sib, idx) => {
          if (sib === entry.target) delay = idx * 80;
        });
        setTimeout(() => {
          entry.target.classList.add('visible');
        }, delay);
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
  revealEls.forEach(el => revealObserver.observe(el));

  // ── Counter animation ─────────────────────────────
  function animateCount(el, target, duration = 1800) {
    let start = 0;
    const step = (timestamp) => {
      if (!start) start = timestamp;
      const progress = Math.min((timestamp - start) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3); // ease-out cubic
      el.textContent = Math.floor(ease * target);
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }

  const counterObserver = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      animateCount(document.getElementById('count-members'), 80);
      animateCount(document.getElementById('count-medals'), 50);
      animateCount(document.getElementById('count-events'), 20);
      counterObserver.disconnect();
    }
  }, { threshold: 0.5 });
  const statsEl = document.querySelector('.hero-stats');
  if (statsEl) counterObserver.observe(statsEl);

  // ── Smooth scroll for nav links ───────────────────
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = 80;
        const top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

  // ── Gallery lightbox ──────────────────────────────
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const lightboxClose = document.getElementById('lightbox-close');

  document.querySelectorAll('.gallery-item img').forEach(img => {
    img.style.cursor = 'zoom-in';
    img.addEventListener('click', () => {
      lightboxImg.src = img.src;
      lightboxImg.alt = img.alt;
      lightbox.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  });

  function closeLightbox() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
    setTimeout(() => { lightboxImg.src = ''; }, 300);
  }

  lightboxClose.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', e => {
    if (e.target === lightbox) closeLightbox();
  });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox();
  });

  // ── Parallax hero (subtle) ────────────────────────
  const heroImg = document.querySelector('.hero-img');
  if (heroImg) {
    window.addEventListener('scroll', () => {
      const scrolled = window.scrollY;
      if (scrolled < window.innerHeight) {
        heroImg.style.transform = `translateY(${scrolled * 0.25}px)`;
      }
    }, { passive: true });
  }

})();
</script>

</body>
</html>
