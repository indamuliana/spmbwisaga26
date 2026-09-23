@extends('layouts.app')

@section('content')

<style>
/* ===== CUSTOM STYLES FOR WELCOME PAGE ===== */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

.welcome-page {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    overflow-x: hidden;
}

/* ── HERO ── */
.hero-section {
    position: relative;
    min-height: 92vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #0f2057 100%);
    overflow: hidden;
}

.hero-grid-bg {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(99,102,241,0.08) 1px, transparent 1px),
        linear-gradient(90deg, rgba(99,102,241,0.08) 1px, transparent 1px);
    background-size: 60px 60px;
}

.hero-glow-1 {
    position: absolute;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
    top: -150px; right: -100px;
    border-radius: 50%;
    animation: pulse-glow 6s ease-in-out infinite;
}

.hero-glow-2 {
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%);
    bottom: -80px; left: 10%;
    border-radius: 50%;
    animation: pulse-glow 8s ease-in-out infinite reverse;
}

@keyframes pulse-glow {
    0%, 100% { transform: scale(1); opacity: 0.7; }
    50% { transform: scale(1.15); opacity: 1; }
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(99,102,241,0.15);
    border: 1px solid rgba(99,102,241,0.35);
    color: #a5b4fc;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.04em;
    backdrop-filter: blur(8px);
    animation: fadeInDown 0.6s ease both;
}

.hero-badge-dot {
    width: 7px; height: 7px;
    background: #34d399;
    border-radius: 50%;
    animation: blink 1.5s ease-in-out infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

.hero-title {
    font-size: clamp(2.2rem, 5vw, 3.8rem);
    font-weight: 900;
    line-height: 1.1;
    color: #fff;
    animation: fadeInUp 0.7s ease 0.1s both;
}

.hero-title span {
    background: linear-gradient(90deg, #818cf8, #34d399, #60a5fa);
    background-size: 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradient-shift 4s ease infinite;
}

@keyframes gradient-shift {
    0%,100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.hero-subtitle {
    font-size: clamp(1rem, 2vw, 1.2rem);
    color: rgba(226,232,240,0.75);
    line-height: 1.7;
    animation: fadeInUp 0.7s ease 0.2s both;
}

.hero-cta-group { animation: fadeInUp 0.7s ease 0.3s both; }

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 32px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    border-radius: 14px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    box-shadow: 0 8px 30px rgba(99,102,241,0.45);
    transition: all 0.3s ease;
    border: none;
}
.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(99,102,241,0.6);
    background: linear-gradient(135deg, #7c3aed, #6366f1);
    color: #fff;
    text-decoration: none;
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 28px;
    background: rgba(255,255,255,0.08);
    color: #e2e8f0;
    border-radius: 14px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
}
.btn-secondary:hover {
    background: rgba(255,255,255,0.15);
    transform: translateY(-3px);
    color: #fff;
    text-decoration: none;
}

/* Hero Stats */
.hero-stats {
    display: flex;
    gap: 2rem;
    animation: fadeInUp 0.7s ease 0.4s both;
}
.stat-item { text-align: left; }
.stat-number {
    font-size: 1.8rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
}
.stat-label {
    font-size: 0.72rem;
    color: rgba(148,163,184,0.9);
    font-weight: 500;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* Hero visual card */
.hero-visual {
    animation: fadeInRight 0.9s ease 0.3s both;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-16px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

/* floating cards inside hero visual */
.floating-card {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(16px);
    border-radius: 16px;
    padding: 16px 20px;
}
.floating-card-anim {
    animation: float 4s ease-in-out infinite;
}
.floating-card-anim-2 {
    animation: float 5s ease-in-out 1s infinite;
}
@keyframes float {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* ── SECTION HEADER ── */
.section-header { text-align: center; margin-bottom: 3.5rem; }
.section-eyebrow {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #6366f1;
    background: rgba(99,102,241,0.08);
    border: 1px solid rgba(99,102,241,0.2);
    padding: 4px 14px;
    border-radius: 999px;
    margin-bottom: 14px;
}
.section-title {
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 900;
    color: #0f172a;
    line-height: 1.2;
    margin: 0 0 14px;
}
.section-desc {
    color: #64748b;
    font-size: 1.05rem;
    max-width: 560px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ── JURUSAN SECTION ── */
.jurusan-section { padding: 80px 0; background: #f8faff; }

.jurusan-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e8edf5;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
    cursor: default;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.jurusan-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 60px rgba(0,0,0,0.1);
    border-color: transparent;
}

.jurusan-card-header {
    padding: 28px 28px 20px;
    position: relative;
    overflow: hidden;
}
.jurusan-icon-wrap {
    width: 60px; height: 60px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem;
    margin-bottom: 20px;
    position: relative; z-index: 1;
}
.jurusan-card-bg-decor {
    position: absolute;
    width: 120px; height: 120px;
    border-radius: 50%;
    top: -30px; right: -20px;
    opacity: 0.12;
}

.jurusan-card-body { padding: 0 28px 24px; flex: 1; }
.jurusan-card-footer {
    padding: 16px 28px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.jurusan-tag {
    display: inline-block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.04em;
    padding: 4px 10px;
    border-radius: 999px;
    margin-right: 6px;
    margin-bottom: 6px;
}

/* ── PRESTASI SECTION ── */
.prestasi-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #0f2057 100%);
    position: relative;
    overflow: hidden;
}
.prestasi-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(99,102,241,0.07) 1px, transparent 1px),
        linear-gradient(90deg, rgba(99,102,241,0.07) 1px, transparent 1px);
    background-size: 48px 48px;
}

.prestasi-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 28px;
    text-align: center;
    transition: all 0.3s ease;
    position: relative; z-index: 1;
}
.prestasi-card:hover {
    background: rgba(255,255,255,0.1);
    transform: translateY(-4px);
    border-color: rgba(99,102,241,0.4);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}
.prestasi-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
    margin: 0 auto 16px;
}
.prestasi-number {
    font-size: 2.4rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    margin-bottom: 6px;
}
.prestasi-label {
    font-size: 0.85rem;
    color: rgba(148,163,184,0.9);
    font-weight: 500;
}

/* highlight cards */
.highlight-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 20px 24px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    transition: all 0.3s ease;
    position: relative; z-index: 1;
}
.highlight-card:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(99,102,241,0.4);
    transform: translateX(4px);
}
.highlight-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

/* ── GALERI SECTION ── */
.galeri-section { padding: 80px 0; background: #fff; }

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: auto;
    gap: 16px;
}
.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    background: #e2e8f0;
}
.gallery-item.tall { grid-row: span 2; }
.gallery-item.wide { grid-column: span 2; }

.gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    min-height: 220px;
    transition: transform 0.5s cubic-bezier(.4,0,.2,1);
    display: block;
}
.gallery-item:hover .gallery-img { transform: scale(1.07); }
.gallery-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15,23,42,0.7) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.35s ease;
    display: flex;
    align-items: flex-end;
    padding: 20px;
}
.gallery-item:hover .gallery-overlay { opacity: 1; }

/* placeholder gallery */
.gallery-placeholder {
    width: 100%;
    min-height: 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 0.85rem;
    font-weight: 500;
    gap: 8px;
}

/* ── FASILITAS SECTION ── */
.fasilitas-section { padding: 80px 0; background: #f8faff; }

.fasilitas-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.fasilitas-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 18px;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
    cursor: default;
}
.fasilitas-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    border-color: transparent;
}
.fasilitas-card-img {
    position: relative;
    overflow: hidden;
    height: 180px;
}
.fasilitas-card-img .gallery-placeholder {
    min-height: 180px;
    height: 100%;
}
.fasilitas-card-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.5s ease;
}
.fasilitas-card:hover .fasilitas-card-img img { transform: scale(1.08); }
.fasilitas-card-body {
    padding: 18px 20px;
}
@media (max-width: 992px) {
    .fasilitas-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .fasilitas-grid { grid-template-columns: 1fr; }
}

/* ── INFO LINKS SECTION ── */
.info-section { padding: 60px 0; background: #f8faff; }

.info-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 28px 24px;
    text-align: center;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    color: inherit;
}
.info-card:hover { 
    transform: translateY(-6px);
    text-decoration: none;
    color: inherit;
}
.info-icon-wrap {
    width: 64px; height: 64px;
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.7rem;
    transition: transform 0.3s ease;
}
.info-card:hover .info-icon-wrap { transform: scale(1.1) rotate(-5deg); }

/* ── PENGUMUMAN ── */
.pengumuman-section { padding: 60px 0; background: #fff; }

/* ── SOSMED SECTION ── */
.sosmed-section { padding: 60px 0; background: #f8faff; }

.sosmed-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 24px 20px;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    background: #fff;
    transition: all 0.3s ease;
    text-decoration: none;
    color: #475569;
    font-size: 0.85rem;
    font-weight: 600;
}
.sosmed-link:hover {
    transform: translateY(-5px);
    color: inherit;
    text-decoration: none;
}
.sosmed-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
}
.sosmed-icon svg { width: 26px; height: 26px; }

/* ── FOOTER CTA ── */
.footer-cta {
    padding: 80px 0;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #0ea5e9 100%);
    position: relative;
    overflow: hidden;
    text-align: center;
}
.footer-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* Countdown timer */
.countdown-wrap {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin: 1.5rem 0;
}
.countdown-box {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 14px;
    padding: 14px 18px;
    text-align: center;
    min-width: 72px;
    backdrop-filter: blur(8px);
}
.countdown-num {
    font-size: 2rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    display: block;
}
.countdown-unit {
    font-size: 0.65rem;
    color: rgba(255,255,255,0.7);
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

/* Utility */
.container-xl {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Scroll reveal animation */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-stats { flex-wrap: wrap; gap: 1.2rem; }
    .gallery-grid {
        grid-template-columns: 1fr 1fr;
    }
    .gallery-item.tall { grid-row: span 1; }
    .gallery-item.wide { grid-column: span 2; }
    .hero-visual { display: none; }
}
@media (max-width: 480px) {
    .gallery-grid { grid-template-columns: 1fr; }
    .gallery-item.wide { grid-column: span 1; }
}
</style>

<div class="welcome-page">

    {{-- ========================================================
         1. HERO SECTION
    ======================================================== --}}
    <section class="hero-section">
        <div class="hero-grid-bg"></div>
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>

        <div class="container-xl" style="padding-top:60px; padding-bottom:60px; width:100%;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center;">
                
                {{-- LEFT: Text Content --}}
                <div>
                    <span class="hero-badge">
                        <span class="hero-badge-dot"></span>
                        PPDB / SPMB Tahun Ajaran 2026/2027
                    </span>

                    <div style="margin-top:20px;">
                        <h1 class="hero-title">
                            Bergabunglah<br>
                            Bersama <span>SMK Wikrama<br>1 Garut</span>
                        </h1>
                    </div>

                    <p class="hero-subtitle" style="margin-top:20px; margin-bottom:32px;">
                        Sekolah unggulan Garut dengan program Teknologi, Bisnis & Pariwisata. 
                        Raih masa depan cerahmu bersama kami.<br>
                        <em style="color:#a5b4fc;">"Ilmu yang Amaliah, Amal yang Ilmiah, Akhlakul Karimah"</em>
                    </p>

                    <div class="hero-cta-group" style="display:flex; gap:14px; flex-wrap:wrap;">
                        <a href="{{ route('pendaftaran') }}" class="btn-primary" id="btn-daftar-hero">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary" id="btn-login-hero">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                            Login
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="hero-stats" style="margin-top:44px; padding-top:36px; border-top:1px solid rgba(255,255,255,0.1);">
                        <div class="stat-item">
                            <div class="stat-number">4</div>
                            <div class="stat-label">Program Keahlian</div>
                        </div>
                        <div class="stat-item" style="border-left:1px solid rgba(255,255,255,0.1); padding-left:2rem;">
                            <div class="stat-number">5.000+</div>
                            <div class="stat-label">Alumni Sukses</div>
                        </div>
                        <div class="stat-item" style="border-left:1px solid rgba(255,255,255,0.1); padding-left:2rem;">
                            <div class="stat-number">30+</div>
                            <div class="stat-label">Penghargaan</div>
                        </div>
                        <div class="stat-item" style="border-left:1px solid rgba(255,255,255,0.1); padding-left:2rem;">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">Terserap Kerja</div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Visual --}}
                <div class="hero-visual">
                    {{-- Logo + floating cards --}}
                    <div style="position:relative; padding:24px;">
                        {{-- Central Logo --}}
                        <div style="display:flex; align-items:center; justify-content:center; margin-bottom:24px;">
                            <div style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:24px; padding:32px; backdrop-filter:blur(16px);">
                                <img src="https://smkwikrama1garut.sch.id/wp-content/uploads/2025/10/wikrama-logo-1.png" 
                                     alt="Logo SMK Wikrama 1 Garut" 
                                     style="width:140px; height:140px; object-fit:contain; filter:drop-shadow(0 0 30px rgba(99,102,241,0.5));">
                            </div>
                        </div>

                        {{-- Float card 1 --}}
                        <div class="floating-card floating-card-anim" 
                             style="position:absolute; top:0; left:-10px; display:flex; align-items:center; gap:12px;">
                            <div style="width:40px;height:40px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                <span style="font-size:1.2rem;">💻</span>
                            </div>
                            <div>
                                <div style="font-size:12px;color:rgba(255,255,255,0.6);font-weight:500;">Program Unggulan</div>
                                <div style="font-size:14px;color:#fff;font-weight:700;">Pengembangan Perangkat Lunak</div>
                            </div>
                        </div>

                        {{-- Float card 2 --}}
                        <div class="floating-card floating-card-anim-2"
                             style="position:absolute; bottom:30px; right:-10px; display:flex; align-items:center; gap:12px;">
                            <div style="width:40px;height:40px;background:linear-gradient(135deg,#10b981,#059669);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                <span style="font-size:1.2rem;">🏆</span>
                            </div>
                            <div>
                                <div style="font-size:12px;color:rgba(255,255,255,0.6);font-weight:500;">Prestasi Nasional</div>
                                <div style="font-size:14px;color:#fff;font-weight:700;">Juara LKS 2025</div>
                            </div>
                        </div>

                        {{-- Float card 3 --}}
                        <div class="floating-card" style="position:absolute; bottom:-20px; left:20px; display:flex; align-items:center; gap:10px; animation: float 6s ease-in-out 0.5s infinite;">
                            <div style="width:36px;height:36px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <span style="font-size:1.1rem;">⭐</span>
                            </div>
                            <div>
                                <div style="font-size:12px;color:rgba(255,255,255,0.6);font-weight:500;">Akreditasi</div>
                                <div style="font-size:14px;color:#fff;font-weight:700;">A (Unggul)</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Wave divider --}}
        <div style="position:absolute; bottom:0; left:0; right:0; line-height:0;">
            <svg viewBox="0 0 1440 80" preserveAspectRatio="none" style="width:100%;height:80px;display:block;">
                <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#f8faff"/>
            </svg>
        </div>
    </section>


    {{-- ========================================================
         2. PENGUMUMAN / MADING (dipindah ke atas)
    ======================================================== --}}
    @if(count($pengumumans) > 0)
    <section class="pengumuman-section" style="padding-top:20px;">
        <div class="container-xl">
            <div class="section-header reveal">
                <span class="section-eyebrow">Informasi Terbaru</span>
                <h2 class="section-title">Papan Pengumuman</h2>
            </div>

            <div class="reveal" x-data="{ activeSlide: 0, interval: null, slides: {{ $pengumumans->count() }} }"
                 x-init="interval = setInterval(() => { activeSlide = (activeSlide + 1) % slides }, 5000)">
                
                <div style="background:#f8faff; border:1px solid #e2e8f0; border-radius:24px; overflow:hidden;">
                    <div style="position:relative; overflow:hidden; aspect-ratio:21/9; min-height:240px;" class="pengumuman-slider">
                        @foreach($pengumumans as $index => $pengumuman)
                        <div x-show="activeSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform translate-x-full"
                             x-transition:enter-end="opacity-100 transform translate-x-0"
                             x-transition:leave="transition ease-in duration-300 absolute inset-0"
                             x-transition:leave-start="opacity-100 transform translate-x-0"
                             x-transition:leave-end="opacity-0 transform -translate-x-full"
                             style="width:100%;height:100%; display:none;">
                            @if($pengumuman->gambar)
                                <img src="{{ Storage::url($pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" style="width:100%;height:100%;object-fit:cover;">
                                <div style="position:absolute;inset:0;background:linear-gradient(to top, rgba(15,23,42,0.85) 0%, transparent 60%); display:flex; flex-direction:column; justify-content:flex-end; padding:2rem 2.5rem; color:#fff;">
                                    <h3 style="font-size:1.6rem;font-weight:800;margin:0 0 8px;">{{ $pengumuman->judul }}</h3>
                                    @if($pengumuman->konten)
                                        <p style="margin:0;color:rgba(226,232,240,0.85);font-size:0.95rem;line-height:1.6; max-width:700px;">{{ Str::limit($pengumuman->konten, 180) }}</p>
                                    @endif
                                </div>
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#4f46e5,#7c3aed); display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:3rem; color:#fff; min-height:240px;">
                                    <h3 style="font-size:2rem;font-weight:800;margin:0 0 12px;">{{ $pengumuman->judul }}</h3>
                                    @if($pengumuman->konten)
                                        <p style="margin:0;color:rgba(226,232,240,0.85);font-size:1.05rem;max-width:600px;line-height:1.7;">{{ $pengumuman->konten }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    {{-- Dots --}}
                    <div style="display:flex; justify-content:center; gap:8px; padding:16px;">
                        @foreach($pengumumans as $index => $pengumuman)
                            <button @click="activeSlide = {{ $index }}; clearInterval(interval); interval = setInterval(() => { activeSlide = (activeSlide + 1) % slides }, 5000)"
                                    :class="activeSlide === {{ $index }} ? 'bg-indigo-600 w-8' : 'bg-slate-300 hover:bg-slate-400 w-3'"
                                    style="height:10px;border-radius:999px;border:none;cursor:pointer;transition:all 0.3s;outline:none;"></button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif


    {{-- ========================================================
         3. JURUSAN SECTION (4 Jurusan)
    ======================================================== --}}
    <section class="jurusan-section">
        <div class="container-xl">
            <div class="section-header reveal">
                <span class="section-eyebrow">Program Keahlian</span>
                <h2 class="section-title">Jurusan yang Tersedia</h2>
                <p class="section-desc">Pilih program keahlian sesuai minat dan bakatmu. Empat program unggulan untuk masa depan cerahmu.</p>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap:24px;" class="reveal">

                {{-- 1. TJKT --}}
                <div class="jurusan-card">
                    <div class="jurusan-card-header" style="background:linear-gradient(135deg,#e0f2fe,#dbeafe);">
                        <div class="jurusan-card-bg-decor" style="background:#0ea5e9;"></div>
                        <div class="jurusan-icon-wrap" style="background:linear-gradient(135deg,#0ea5e9,#0284c7);">🌐</div>
                        <h4 style="font-size:1.1rem;font-weight:800;color:#0c4a6e;margin:0 0 4px;">Teknik Jaringan Komputer dan Telekomunikasi</h4>
                        <p style="font-size:0.8rem;color:#0ea5e9;font-weight:600;margin:0;">TJKT</p>
                    </div>
                    <div class="jurusan-card-body">
                        <p style="font-size:0.88rem;color:#64748b;line-height:1.65;margin:12px 0 16px;">
                            Instalasi, konfigurasi, dan pemeliharaan jaringan komputer, infrastruktur IT, serta sistem telekomunikasi modern.
                        </p>
                        <div>
                            <span class="jurusan-tag" style="background:#e0f2fe;color:#0369a1;">Networking</span>
                            <span class="jurusan-tag" style="background:#e0f2fe;color:#0369a1;">Server</span>
                            <span class="jurusan-tag" style="background:#e0f2fe;color:#0369a1;">Telekomunikasi</span>
                            <span class="jurusan-tag" style="background:#e0f2fe;color:#0369a1;">Security</span>
                        </div>
                    </div>
                    <div class="jurusan-card-footer">
                        <span style="font-size:0.8rem;color:#94a3b8;">Karir: Network Eng. · IT Support</span>
                        <svg style="width:18px;height:18px;color:#0ea5e9;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>

                {{-- 2. PPLG --}}
                <div class="jurusan-card">
                    <div class="jurusan-card-header" style="background:linear-gradient(135deg,#ede9fe,#f0f9ff);">
                        <div class="jurusan-card-bg-decor" style="background:#6366f1;"></div>
                        <div class="jurusan-icon-wrap" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">💻</div>
                        <h4 style="font-size:1.1rem;font-weight:800;color:#1e1b4b;margin:0 0 4px;">Pengembangan Perangkat Lunak dan Gim</h4>
                        <p style="font-size:0.8rem;color:#6366f1;font-weight:600;margin:0;">PPLG</p>
                    </div>
                    <div class="jurusan-card-body">
                        <p style="font-size:0.88rem;color:#64748b;line-height:1.65;margin:12px 0 16px;">
                            Merancang dan membangun aplikasi web, mobile, game, serta sistem perangkat lunak modern dengan teknologi terkini.
                        </p>
                        <div>
                            <span class="jurusan-tag" style="background:#ede9fe;color:#6d28d9;">Web Dev</span>
                            <span class="jurusan-tag" style="background:#ede9fe;color:#6d28d9;">Mobile App</span>
                            <span class="jurusan-tag" style="background:#ede9fe;color:#6d28d9;">Game Dev</span>
                            <span class="jurusan-tag" style="background:#ede9fe;color:#6d28d9;">UI/UX</span>
                        </div>
                    </div>
                    <div class="jurusan-card-footer">
                        <span style="font-size:0.8rem;color:#94a3b8;">Karir: Developer · Game Programmer</span>
                        <svg style="width:18px;height:18px;color:#6366f1;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>

                {{-- 3. PEMASARAN --}}
                <div class="jurusan-card">
                    <div class="jurusan-card-header" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);">
                        <div class="jurusan-card-bg-decor" style="background:#10b981;"></div>
                        <div class="jurusan-icon-wrap" style="background:linear-gradient(135deg,#10b981,#059669);">🛍️</div>
                        <h4 style="font-size:1.1rem;font-weight:800;color:#064e3b;margin:0 0 4px;">Pemasaran</h4>
                        <p style="font-size:0.8rem;color:#059669;font-weight:600;margin:0;">PM</p>
                    </div>
                    <div class="jurusan-card-body">
                        <p style="font-size:0.88rem;color:#64748b;line-height:1.65;margin:12px 0 16px;">
                            Strategi pemasaran digital & konvensional, manajemen bisnis, e-commerce, dan kewirausahaan era digital.
                        </p>
                        <div>
                            <span class="jurusan-tag" style="background:#ecfdf5;color:#065f46;">Digital Marketing</span>
                            <span class="jurusan-tag" style="background:#ecfdf5;color:#065f46;">E-Commerce</span>
                            <span class="jurusan-tag" style="background:#ecfdf5;color:#065f46;">Branding</span>
                            <span class="jurusan-tag" style="background:#ecfdf5;color:#065f46;">Sales</span>
                        </div>
                    </div>
                    <div class="jurusan-card-footer">
                        <span style="font-size:0.8rem;color:#94a3b8;">Karir: Marketer · Entrepreneur</span>
                        <svg style="width:18px;height:18px;color:#10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>

                {{-- 4. PERHOTELAN --}}
                <div class="jurusan-card">
                    <div class="jurusan-card-header" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);">
                        <div class="jurusan-card-bg-decor" style="background:#f97316;"></div>
                        <div class="jurusan-icon-wrap" style="background:linear-gradient(135deg,#f97316,#ea580c);">🏨</div>
                        <h4 style="font-size:1.1rem;font-weight:800;color:#431407;margin:0 0 4px;">Perhotelan</h4>
                        <p style="font-size:0.8rem;color:#ea580c;font-weight:600;margin:0;">HTL</p>
                    </div>
                    <div class="jurusan-card-body">
                        <p style="font-size:0.88rem;color:#64748b;line-height:1.65;margin:12px 0 16px;">
                            Manajemen hotel, housekeeping, front office, food & beverage service, dan hospitality profesional.
                        </p>
                        <div>
                            <span class="jurusan-tag" style="background:#fff7ed;color:#c2410c;">Front Office</span>
                            <span class="jurusan-tag" style="background:#fff7ed;color:#c2410c;">F&B Service</span>
                            <span class="jurusan-tag" style="background:#fff7ed;color:#c2410c;">Housekeeping</span>
                            <span class="jurusan-tag" style="background:#fff7ed;color:#c2410c;">Laundry</span>
                        </div>
                    </div>
                    <div class="jurusan-card-footer">
                        <span style="font-size:0.8rem;color:#94a3b8;">Karir: Hotelier · F&B Manager</span>
                        <svg style="width:18px;height:18px;color:#f97316;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ========================================================
         3. PRESTASI SECTION
    ======================================================== --}}
    <section class="prestasi-section">
        <div class="container-xl">
            <div class="section-header reveal" style="color:#fff;">
                <span class="section-eyebrow" style="background:rgba(99,102,241,0.2);border-color:rgba(99,102,241,0.4);color:#a5b4fc;">Keunggulan Kami</span>
                <h2 class="section-title" style="color:#fff;">Prestasi & Pencapaian</h2>
                <p class="section-desc" style="color:rgba(148,163,184,0.9);">SMK Wikrama 1 Garut terus berprestasi di tingkat regional, nasional, dan internasional.</p>
            </div>

            {{-- Stats Grid --}}
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:16px; margin-bottom:3rem;" class="reveal">
                <div class="prestasi-card">
                    <div class="prestasi-icon" style="background:rgba(99,102,241,0.2);">🏆</div>
                    <div class="prestasi-number">30+</div>
                    <div class="prestasi-label">Penghargaan<br>Nasional & Regional</div>
                </div>
                <div class="prestasi-card">
                    <div class="prestasi-icon" style="background:rgba(16,185,129,0.2);">🎓</div>
                    <div class="prestasi-number">5.000+</div>
                    <div class="prestasi-label">Alumni<br>Berprestasi</div>
                </div>
                <div class="prestasi-card">
                    <div class="prestasi-icon" style="background:rgba(245,158,11,0.2);">⭐</div>
                    <div class="prestasi-number">95%</div>
                    <div class="prestasi-label">Tingkat Serapan<br>Kerja & Kuliah</div>
                </div>
                <div class="prestasi-card">
                    <div class="prestasi-icon" style="background:rgba(239,68,68,0.2);">🤝</div>
                    <div class="prestasi-number">100+</div>
                    <div class="prestasi-label">Mitra Industri<br>& Perusahaan</div>
                </div>
                <div class="prestasi-card">
                    <div class="prestasi-icon" style="background:rgba(14,165,233,0.2);">📜</div>
                    <div class="prestasi-number">A</div>
                    <div class="prestasi-label">Akreditasi<br>BAN-SM (Unggul)</div>
                </div>
            </div>

            {{-- Highlight Cards --}}
            <div class="reveal">
                <h3 style="color:#fff;font-size:1.2rem;font-weight:700;margin-bottom:20px;">Pencapaian Terbaru</h3>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:16px;">
                    <div class="highlight-card">
                        <div class="highlight-icon" style="background:rgba(250,204,21,0.15);">🥇</div>
                        <div>
                            <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:4px;">Juara 1 LKS Tingkat Provinsi Jawa Barat</div>
                            <div style="font-size:0.8rem;color:rgba(148,163,184,0.8);">Bidang Web Technology — 2025</div>
                        </div>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon" style="background:rgba(99,102,241,0.15);">🌏</div>
                        <div>
                            <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:4px;">Peserta WorldSkills Competition</div>
                            <div style="font-size:0.8rem;color:rgba(148,163,184,0.8);">Bidang IT Network Systems — 2024</div>
                        </div>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon" style="background:rgba(16,185,129,0.15);">🏨</div>
                        <div>
                            <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:4px;">Juara 1 LKS Perhotelan Nasional</div>
                            <div style="font-size:0.8rem;color:rgba(148,163,184,0.8);">Kategori Front Office Service — 2025</div>
                        </div>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon" style="background:rgba(236,72,153,0.15);">🎨</div>
                        <div>
                            <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:4px;">Juara Desain Grafis Tingkat Nasional</div>
                            <div style="font-size:0.8rem;color:rgba(148,163,184,0.8);">Kategori Multimedia — 2025</div>
                        </div>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon" style="background:rgba(245,158,11,0.15);">📈</div>
                        <div>
                            <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:4px;">Peringkat 1 SMK Terbaik Kab. Garut</div>
                            <div style="font-size:0.8rem;color:rgba(148,163,184,0.8);">Pemeringkatan Kemendikbudristek — 2025</div>
                        </div>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon" style="background:rgba(14,165,233,0.15);">🍳</div>
                        <div>
                            <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:4px;">Juara Kuliner Terbaik Jawa Barat</div>
                            <div style="font-size:0.8rem;color:rgba(148,163,184,0.8);">Festival Kuliner Nusantara — 2025</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ========================================================
         5. GALERI KEGIATAN
    ======================================================== --}}
    <section class="galeri-section">
        <div class="container-xl">
            <div class="section-header reveal">
                <span class="section-eyebrow">Kehidupan Sekolah</span>
                <h2 class="section-title">Galeri Kegiatan</h2>
                <p class="section-desc">Sekilas kehidupan belajar, praktik, dan prestasi di SMK Wikrama 1 Garut.</p>
            </div>

            <div class="gallery-grid reveal">
                {{-- Item 1: tall --}}
                <div class="gallery-item tall">
                    <div class="gallery-placeholder" style="background:linear-gradient(135deg,#1e1b4b,#4f46e5); min-height:460px;">
                        <span style="font-size:3rem;">💻</span>
                        <span style="color:rgba(255,255,255,0.7);font-weight:700;">Lab Komputer</span>
                        <span style="color:rgba(255,255,255,0.4);font-size:0.75rem;">Ganti dengan foto asli</span>
                    </div>
                    <div class="gallery-overlay">
                        <span style="color:#fff;font-weight:700;font-size:0.9rem;">Laboratorium Komputer Modern</span>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="gallery-item">
                    <div class="gallery-placeholder" style="background:linear-gradient(135deg,#064e3b,#10b981);">
                        <span style="font-size:2.5rem;">🏨</span>
                        <span style="color:rgba(255,255,255,0.7);font-weight:700;">Praktik Perhotelan</span>
                    </div>
                    <div class="gallery-overlay">
                        <span style="color:#fff;font-weight:700;font-size:0.9rem;">Praktik Perhotelan</span>
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="gallery-item">
                    <div class="gallery-placeholder" style="background:linear-gradient(135deg,#431407,#f97316);">
                        <span style="font-size:2.5rem;">🛍️</span>
                        <span style="color:rgba(255,255,255,0.7);font-weight:700;">Pemasaran</span>
                    </div>
                    <div class="gallery-overlay">
                        <span style="color:#fff;font-weight:700;font-size:0.9rem;">Kegiatan Pemasaran</span>
                    </div>
                </div>

                {{-- Item 4: wide --}}
                <div class="gallery-item wide">
                    <div class="gallery-placeholder" style="background:linear-gradient(135deg,#0c4a6e,#0ea5e9);">
                        <span style="font-size:2.8rem;">🌐</span>
                        <span style="color:rgba(255,255,255,0.7);font-weight:700;">Jaringan & Telekomunikasi</span>
                        <span style="color:rgba(255,255,255,0.4);font-size:0.75rem;">Ganti dengan foto asli</span>
                    </div>
                    <div class="gallery-overlay">
                        <span style="color:#fff;font-weight:700;font-size:0.9rem;">Lab Jaringan & Telekomunikasi</span>
                    </div>
                </div>

                {{-- Item 5 --}}
                <div class="gallery-item">
                    <div class="gallery-placeholder" style="background:linear-gradient(135deg,#1e1b4b,#7c3aed);">
                        <span style="font-size:2.5rem;">🏆</span>
                        <span style="color:rgba(255,255,255,0.7);font-weight:700;">Lomba & Kompetisi</span>
                    </div>
                    <div class="gallery-overlay">
                        <span style="color:#fff;font-weight:700;font-size:0.9rem;">Ajang Lomba & Kompetisi</span>
                    </div>
                </div>

                {{-- Item 6 --}}
                <div class="gallery-item">
                    <div class="gallery-placeholder" style="background:linear-gradient(135deg,#713f12,#eab308);">
                        <span style="font-size:2.5rem;">🎓</span>
                        <span style="color:rgba(255,255,255,0.7);font-weight:700;">Wisuda & Kelulusan</span>
                    </div>
                    <div class="gallery-overlay">
                        <span style="color:#fff;font-weight:700;font-size:0.9rem;">Wisuda & Kelulusan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ========================================================
         5b. FASILITAS & RUANGAN
    ======================================================== --}}
    <section class="fasilitas-section">
        <div class="container-xl">
            <div class="section-header reveal">
                <span class="section-eyebrow">Sarana & Prasarana</span>
                <h2 class="section-title">Fasilitas & Ruangan</h2>
                <p class="section-desc">Ruangan modern dan fasilitas lengkap untuk menunjang proses belajar mengajar yang optimal.</p>
            </div>

            <div class="fasilitas-grid reveal">
                {{-- Lab Komputer --}}
                <div class="fasilitas-card">
                    <div class="fasilitas-card-img">
                        <div class="gallery-placeholder" style="background:linear-gradient(135deg,#1e1b4b,#6366f1);">
                            <span style="font-size:2.2rem;">🖥️</span>
                            <span style="color:rgba(255,255,255,0.7);font-weight:600;">Foto</span>
                        </div>
                    </div>
                    <div class="fasilitas-card-body">
                        <h4 style="font-size:0.95rem;font-weight:700;color:#0f172a;margin:0 0 4px;">Lab Komputer</h4>
                        <p style="font-size:0.8rem;color:#64748b;margin:0;">Dilengkapi PC terbaru untuk praktik pemrograman dan jaringan</p>
                    </div>
                </div>

                {{-- Lab Jaringan --}}
                <div class="fasilitas-card">
                    <div class="fasilitas-card-img">
                        <div class="gallery-placeholder" style="background:linear-gradient(135deg,#0c4a6e,#0ea5e9);">
                            <span style="font-size:2.2rem;">🌐</span>
                            <span style="color:rgba(255,255,255,0.7);font-weight:600;">Foto</span>
                        </div>
                    </div>
                    <div class="fasilitas-card-body">
                        <h4 style="font-size:0.95rem;font-weight:700;color:#0f172a;margin:0 0 4px;">Lab Jaringan</h4>
                        <p style="font-size:0.8rem;color:#64748b;margin:0;">Perangkat router, switch, dan server untuk praktik jaringan</p>
                    </div>
                </div>

                {{-- Ruang Praktik Hotel --}}
                <div class="fasilitas-card">
                    <div class="fasilitas-card-img">
                        <div class="gallery-placeholder" style="background:linear-gradient(135deg,#431407,#f97316);">
                            <span style="font-size:2.2rem;">🛏️</span>
                            <span style="color:rgba(255,255,255,0.7);font-weight:600;">Foto</span>
                        </div>
                    </div>
                    <div class="fasilitas-card-body">
                        <h4 style="font-size:0.95rem;font-weight:700;color:#0f172a;margin:0 0 4px;">Ruang Praktik Hotel</h4>
                        <p style="font-size:0.8rem;color:#64748b;margin:0;">Simulasi kamar hotel lengkap untuk front office & housekeeping</p>
                    </div>
                </div>

                {{-- Perpustakaan --}}
                <div class="fasilitas-card">
                    <div class="fasilitas-card-img">
                        <div class="gallery-placeholder" style="background:linear-gradient(135deg,#064e3b,#10b981);">
                            <span style="font-size:2.2rem;">📚</span>
                            <span style="color:rgba(255,255,255,0.7);font-weight:600;">Foto</span>
                        </div>
                    </div>
                    <div class="fasilitas-card-body">
                        <h4 style="font-size:0.95rem;font-weight:700;color:#0f172a;margin:0 0 4px;">Perpustakaan</h4>
                        <p style="font-size:0.8rem;color:#64748b;margin:0;">Koleksi buku lengkap & ruang baca digital yang nyaman</p>
                    </div>
                </div>

                {{-- Masjid --}}
                <div class="fasilitas-card">
                    <div class="fasilitas-card-img">
                        <div class="gallery-placeholder" style="background:linear-gradient(135deg,#713f12,#eab308);">
                            <span style="font-size:2.2rem;">🕌</span>
                            <span style="color:rgba(255,255,255,0.7);font-weight:600;">Foto</span>
                        </div>
                    </div>
                    <div class="fasilitas-card-body">
                        <h4 style="font-size:0.95rem;font-weight:700;color:#0f172a;margin:0 0 4px;">Masjid</h4>
                        <p style="font-size:0.8rem;color:#64748b;margin:0;">Tempat ibadah yang luas dan nyaman untuk seluruh warga sekolah</p>
                    </div>
                </div>

                {{-- Lapangan Olahraga --}}
                <div class="fasilitas-card">
                    <div class="fasilitas-card-img">
                        <div class="gallery-placeholder" style="background:linear-gradient(135deg,#14532d,#22c55e);">
                            <span style="font-size:2.2rem;">⚽</span>
                            <span style="color:rgba(255,255,255,0.7);font-weight:600;">Foto</span>
                        </div>
                    </div>
                    <div class="fasilitas-card-body">
                        <h4 style="font-size:0.95rem;font-weight:700;color:#0f172a;margin:0 0 4px;">Lapangan Olahraga</h4>
                        <p style="font-size:0.8rem;color:#64748b;margin:0;">Lapangan multifungsi untuk kegiatan olahraga & upacara</p>
                    </div>
                </div>

                {{-- Aula --}}
                <div class="fasilitas-card">
                    <div class="fasilitas-card-img">
                        <div class="gallery-placeholder" style="background:linear-gradient(135deg,#4a044e,#d946ef);">
                            <span style="font-size:2.2rem;">🏛️</span>
                            <span style="color:rgba(255,255,255,0.7);font-weight:600;">Foto</span>
                        </div>
                    </div>
                    <div class="fasilitas-card-body">
                        <h4 style="font-size:0.95rem;font-weight:700;color:#0f172a;margin:0 0 4px;">Aula Serbaguna</h4>
                        <p style="font-size:0.8rem;color:#64748b;margin:0;">Ruang luas untuk acara, seminar, dan kegiatan bersama</p>
                    </div>
                </div>

                {{-- Kantin --}}
                <div class="fasilitas-card">
                    <div class="fasilitas-card-img">
                        <div class="gallery-placeholder" style="background:linear-gradient(135deg,#7c2d12,#f43f5e);">
                            <span style="font-size:2.2rem;">🍽️</span>
                            <span style="color:rgba(255,255,255,0.7);font-weight:600;">Foto</span>
                        </div>
                    </div>
                    <div class="fasilitas-card-body">
                        <h4 style="font-size:0.95rem;font-weight:700;color:#0f172a;margin:0 0 4px;">Kantin & Food Court</h4>
                        <p style="font-size:0.8rem;color:#64748b;margin:0;">Area makan bersih & sehat dengan menu bervariasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ========================================================
         5. INFO LINKS
    ======================================================== --}}
    <section class="info-section">
        <div class="container-xl">
            <div class="section-header reveal">
                <span class="section-eyebrow">Informasi</span>
                <h2 class="section-title">Butuh Bantuan?</h2>
                <p class="section-desc">Akses berbagai sumber informasi PPDB dengan mudah.</p>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px;" class="reveal">
                <a href="https://brosur.smkwikrama1garut.sch.id" target="_blank" class="info-card" 
                   style="border-color:#d1fae5;" 
                   onmouseover="this.style.boxShadow='0 20px 40px rgba(16,185,129,0.15)'; this.style.borderColor='#10b981';"
                   onmouseout="this.style.boxShadow=''; this.style.borderColor='#d1fae5';">
                    <div class="info-icon-wrap" style="background:#ecfdf5; color:#059669;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    </div>
                    <div>
                        <div style="font-weight:700;color:#0f172a;font-size:0.95rem;">Download Brosur</div>
                        <div style="font-size:0.8rem;color:#64748b;margin-top:4px;">Informasi lengkap PPDB</div>
                    </div>
                </a>

                <a href="https://bit.ly/wikramagarut" target="_blank" class="info-card"
                   style="border-color:#fee2e2;"
                   onmouseover="this.style.boxShadow='0 20px 40px rgba(239,68,68,0.15)'; this.style.borderColor='#ef4444';"
                   onmouseout="this.style.boxShadow=''; this.style.borderColor='#fee2e2';">
                    <div class="info-icon-wrap" style="background:#fef2f2; color:#dc2626;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <div>
                        <div style="font-weight:700;color:#0f172a;font-size:0.95rem;">Lokasi Sekolah</div>
                        <div style="font-size:0.8rem;color:#64748b;margin-top:4px;">Cek rute via Google Maps</div>
                    </div>
                </a>

                <a href="https://wa.me/628112232880" target="_blank" class="info-card"
                   style="border-color:#dcfce7;"
                   onmouseover="this.style.boxShadow='0 20px 40px rgba(34,197,94,0.15)'; this.style.borderColor='#22c55e';"
                   onmouseout="this.style.boxShadow=''; this.style.borderColor='#dcfce7';">
                    <div class="info-icon-wrap" style="background:#f0fdf4; color:#16a34a;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    </div>
                    <div>
                        <div style="font-weight:700;color:#0f172a;font-size:0.95rem;">Chat Admin</div>
                        <div style="font-size:0.8rem;color:#64748b;margin-top:4px;">Konsultasi via WhatsApp</div>
                    </div>
                </a>

                <a href="{{ route('pendaftaran') }}" class="info-card"
                   style="border-color:#e0e7ff;"
                   onmouseover="this.style.boxShadow='0 20px 40px rgba(99,102,241,0.15)'; this.style.borderColor='#6366f1';"
                   onmouseout="this.style.boxShadow=''; this.style.borderColor='#e0e7ff';">
                    <div class="info-icon-wrap" style="background:#eef2ff; color:#6366f1;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <div style="font-weight:700;color:#0f172a;font-size:0.95rem;">Form Pendaftaran</div>
                        <div style="font-size:0.8rem;color:#64748b;margin-top:4px;">Daftar online sekarang</div>
                    </div>
                </a>
            </div>
        </div>
    </section>


    {{-- Pengumuman sudah dipindah ke atas (sebelum jurusan) --}}


    {{-- ========================================================
         7. SOSMED SECTION
    ======================================================== --}}
    <section class="sosmed-section">
        <div class="container-xl">
            <div class="section-header reveal">
                <span class="section-eyebrow">Tetap Terhubung</span>
                <h2 class="section-title">Ikuti Kami</h2>
                <p class="section-desc">Dapatkan informasi terbaru seputar PPDB dan kegiatan sekolah melalui media sosial kami.</p>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap:16px; max-width:720px; margin:0 auto;" class="reveal">
                <a href="https://www.instagram.com/smkwikrama1garut/" target="_blank" class="sosmed-link"
                   onmouseover="this.style.borderColor='#e1306c'; this.style.boxShadow='0 12px 30px rgba(225,48,108,0.15)'; this.style.color='#e1306c';"
                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''; this.style.color='#475569';">
                    <div class="sosmed-icon" style="background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);">
                        <svg fill="#fff" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    </div>
                    <span>Instagram</span>
                </a>

                <a href="#" target="_blank" class="sosmed-link"
                   onmouseover="this.style.borderColor='#000'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'; this.style.color='#000';"
                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''; this.style.color='#475569';">
                    <div class="sosmed-icon" style="background:#000;">
                        <svg fill="#fff" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v7.2c0 1.63-.51 3.25-1.48 4.54-1.52 2.01-4.05 3.17-6.57 3.05-2.49-.11-4.83-1.42-6.1-3.48-1.3-2.12-1.51-4.84-.52-7.14.99-2.28 3.01-4.05 5.37-4.63 1.18-.29 2.42-.31 3.63-.07v4.06c-1.3-.23-2.67-.09-3.79.62-.98.63-1.64 1.64-1.84 2.78-.22 1.23.09 2.53.84 3.48.74.93 1.91 1.48 3.11 1.52 1.21.03 2.41-.47 3.18-1.35.79-.9 1.15-2.13 1.17-3.34V.02h-4.08z"/></svg>
                    </div>
                    <span>TikTok</span>
                </a>

                <a href="#" target="_blank" class="sosmed-link"
                   onmouseover="this.style.borderColor='#1877f2'; this.style.boxShadow='0 12px 30px rgba(24,119,242,0.15)'; this.style.color='#1877f2';"
                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''; this.style.color='#475569';">
                    <div class="sosmed-icon" style="background:#1877f2;">
                        <svg fill="#fff" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </div>
                    <span>Facebook</span>
                </a>

                <a href="#" target="_blank" class="sosmed-link"
                   onmouseover="this.style.borderColor='#ff0000'; this.style.boxShadow='0 12px 30px rgba(255,0,0,0.15)'; this.style.color='#ff0000';"
                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''; this.style.color='#475569';">
                    <div class="sosmed-icon" style="background:#ff0000;">
                        <svg fill="#fff" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" /></svg>
                    </div>
                    <span>YouTube</span>
                </a>
            </div>
        </div>
    </section>


    {{-- ========================================================
         8. FOOTER CTA
    ======================================================== --}}
    <section class="footer-cta">
        <div class="container-xl" style="position:relative;z-index:1;">
            <div class="reveal">
                <p style="font-size:0.9rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.7);margin:0 0 12px;">Pendaftaran Dibuka Sekarang</p>
                <h2 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:#fff;margin:0 0 12px;line-height:1.15;">
                    Raih Masa Depanmu<br>Bersama Kami
                </h2>
                <p style="color:rgba(255,255,255,0.8);font-size:1.05rem;margin:0 0 32px;max-width:520px;margin-left:auto;margin-right:auto;line-height:1.7;">
                    Daftarkan dirimu sekarang dan jadilah bagian dari keluarga besar SMK Wikrama 1 Garut. Kuota terbatas!
                </p>

                {{-- Countdown --}}
                <div class="countdown-wrap" id="countdown-wrapper">
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-days">--</span>
                        <span class="countdown-unit">Hari</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-hours">--</span>
                        <span class="countdown-unit">Jam</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-mins">--</span>
                        <span class="countdown-unit">Menit</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-secs">--</span>
                        <span class="countdown-unit">Detik</span>
                    </div>
                </div>
                <p style="color:rgba(255,255,255,0.5);font-size:0.78rem;margin-bottom:28px;">Batas waktu pendaftaran: 31 Oktober 2026</p>

                <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
                    <a href="{{ route('pendaftaran') }}" id="btn-daftar-footer"
                       style="display:inline-flex;align-items:center;gap:10px;padding:16px 36px;background:#fff;color:#4f46e5;border-radius:14px;font-weight:800;font-size:1.05rem;text-decoration:none;box-shadow:0 8px 30px rgba(0,0,0,0.2);transition:all 0.3s ease;"
                       onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,0.3)';"
                       onmouseout="this.style.transform=''; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.2)';">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        Daftar Sekarang — Gratis
                    </a>
                    <a href="{{ route('login') }}" id="btn-login-footer"
                       style="display:inline-flex;align-items:center;gap:10px;padding:15px 28px;background:rgba(255,255,255,0.12);color:#fff;border-radius:14px;font-weight:600;font-size:1rem;text-decoration:none;border:1px solid rgba(255,255,255,0.3);backdrop-filter:blur(8px);transition:all 0.3s ease;"
                       onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-3px)';"
                       onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.transform='';">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
// ── Scroll Reveal ──
const revealEls = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.classList.add('visible');
            }, i * 80);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
revealEls.forEach(el => observer.observe(el));

// ── Countdown Timer ──
function updateCountdown() {
    const deadline = new Date('2026-10-31T23:59:59');
    const now = new Date();
    const diff = deadline - now;

    if (diff <= 0) {
        document.getElementById('countdown-wrapper').innerHTML = '<div style="color:rgba(255,255,255,0.7);font-size:1rem;font-weight:600;padding:12px;">Pendaftaran telah ditutup.</div>';
        return;
    }

    const days  = Math.floor(diff / (1000*60*60*24));
    const hours = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));
    const mins  = Math.floor((diff % (1000*60*60)) / (1000*60));
    const secs  = Math.floor((diff % (1000*60)) / 1000);

    const pad = n => String(n).padStart(2, '0');
    document.getElementById('cd-days').textContent  = pad(days);
    document.getElementById('cd-hours').textContent = pad(hours);
    document.getElementById('cd-mins').textContent  = pad(mins);
    document.getElementById('cd-secs').textContent  = pad(secs);
}
updateCountdown();
setInterval(updateCountdown, 1000);
</script>

@endsection
