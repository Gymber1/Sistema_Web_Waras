<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARAS - Portal Unificado</title>
    <link rel="icon" type="image/png" href="/Logo-Waras.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; color: #333; line-height: 1.6; background: #f9f8f6; }

        /* ── NAVBAR ── */
        .header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 1.25rem 0;
            background: rgba(0,0,0,0.35);
            backdrop-filter: blur(4px);
            transition: all 0.3s ease;
        }
        .header.scrolled {
            background: #111;
            padding: 0.75rem 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.4);
        }
        .nav-wrapper {
            max-width: 1300px; margin: 0 auto; padding: 0 2rem;
            display: flex; justify-content: space-between; align-items: center;
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 700;
            color: #cda274; letter-spacing: .15em;
            text-decoration: none;
        }
        .desktop-nav {
            display: flex; align-items: center; gap: 2.5rem;
        }
        .nav-link {
            color: white; text-decoration: none;
            font-size: .75rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .1em;
            transition: color .3s;
        }
        .nav-link:hover { color: #cda274; }
        .btn-admin {
            background: #cda274; color: white;
            padding: .55rem 1.4rem;
            font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            text-decoration: none;
            transition: background .3s;
            border: none; cursor: pointer;
        }
        .btn-admin:hover { background: #b88e62; }
        .btn-login {
            background: transparent; color: white;
            padding: .55rem 1.4rem;
            font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,.4);
            transition: all .3s;
        }
        .btn-login:hover { background: rgba(255,255,255,.1); border-color: white; }

        /* Mobile */
        .hamburger-btn { display: none; background: none; border: none; cursor: pointer; color: white; padding: .5rem; }
        .hamburger-btn svg { width: 26px; height: 26px; }
        .mobile-menu {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.97); z-index: 2000;
            flex-direction: column; align-items: center; justify-content: center; gap: 2rem;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu-close { position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; color: white; cursor: pointer; font-size: 1.6rem; }
        .mobile-nav-link { color: white; text-decoration: none; font-size: 1.4rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; }
        .mobile-nav-link:hover { color: #cda274; }
        .mobile-nav-btn { background: #cda274; color: white; padding: .75rem 2.5rem; font-weight: 700; font-size: 1rem; text-decoration: none; letter-spacing: .05em; }

        @media(max-width: 768px) {
            .desktop-nav { display: none; }
            .hamburger-btn { display: block; }
        }

        /* ── HERO ── */
        .hero-section {
            position: relative; height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center; background-repeat: no-repeat;
        }
        .hero-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.60); }
        .hero-content {
            position: relative; z-index: 2;
            text-align: center; color: white;
            max-width: 900px; padding: 2rem; margin-top: 4rem;
        }
        .hero-eyebrow {
            color: #cda274;
            font-size: .8rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .35em;
            margin-bottom: 1.25rem;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.8rem, 6vw, 5.5rem);
            font-weight: 700; line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        .hero-subtitle {
            font-size: 1.1rem; font-weight: 300;
            font-style: italic; color: rgba(255,255,255,.8);
            max-width: 650px; margin: 0 auto 2.5rem;
            line-height: 1.8;
        }
        .hero-cta {
            display: inline-block;
            background: #cda274; color: white;
            padding: 1rem 2.5rem;
            font-size: .8rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .15em;
            text-decoration: none;
            transition: all .3s;
        }
        .hero-cta:hover { background: white; color: #cda274; }
        .scroll-indicator {
            position: absolute; bottom: 2.5rem; left: 50%;
            transform: translateX(-50%); z-index: 3;
            animation: bounce 2s infinite;
        }
        .scroll-indicator svg { width: 28px; height: 28px; stroke: rgba(255,255,255,.6); fill: none; }
        @keyframes bounce {
            0%,100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(8px); }
        }

        /* ── ABOUT ── */
        .about-section {
            padding: 7rem 2rem;
            background: #f9f8f6;
        }
        .about-inner {
            max-width: 1300px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
        }
        .about-images {
            display: flex; gap: 1.5rem; align-items: flex-start;
        }
        .about-img-1 {
            width: 50%; aspect-ratio: 3/4;
            object-fit: cover; margin-top: 3rem;
        }
        .about-img-2 {
            width: 50%; aspect-ratio: 3/4;
            object-fit: cover;
        }
        .about-eyebrow {
            color: #cda274; font-size: .7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .25em;
            margin-bottom: .75rem;
        }
        .about-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            color: #111; line-height: 1.2; margin-bottom: 1.5rem;
        }
        .about-text {
            color: #6b7280; font-size: .95rem; font-weight: 300;
            line-height: 1.9; margin-bottom: 1rem;
        }
        .about-boxes {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem;
        }
        .about-box {
            border: 1px solid #e5e7eb; background: white;
            padding: 1.5rem; cursor: pointer;
            transition: border-color .3s;
        }
        .about-box:hover { border-color: #cda274; }
        .about-box h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; color: #111; margin-bottom: .4rem;
            transition: color .3s;
        }
        .about-box:hover h4 { color: #cda274; }
        .about-box p { font-size: .82rem; color: #9ca3af; font-weight: 300; }

        @media(max-width: 900px) {
            .about-inner { grid-template-columns: 1fr; gap: 3rem; }
            .about-images { max-width: 500px; margin: 0 auto; }
        }

        /* ── COLLECTIONS ── */
        .collections-section {
            padding: 7rem 2rem;
            background: white;
        }
        .section-header {
            text-align: center; max-width: 600px;
            margin: 0 auto 4rem;
        }
        .section-eyebrow {
            color: #cda274; font-size: .7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .25em;
            margin-bottom: .75rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            color: #111;
        }
        .collections-grid {
            max-width: 1300px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;
        }
        .collection-card {
            position: relative; height: 520px;
            overflow: hidden; background: #111; cursor: pointer;
        }
        .collection-img {
            position: absolute; inset: 0;
            width: 100%; height: 100%; object-fit: cover;
            opacity: .7; transition: transform .7s ease, opacity .5s ease;
        }
        .collection-card:hover .collection-img { transform: scale(1.08); opacity: .5; }
        .collection-tag {
            position: absolute; top: 2rem; right: 2rem;
            border: 1px solid rgba(255,255,255,.35);
            background: rgba(0,0,0,.2); backdrop-filter: blur(4px);
            padding: .5rem .6rem;
            writing-mode: vertical-rl; transform: rotate(180deg);
            color: white; font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .18em;
        }
        .collection-bottom {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 2rem;
            background: linear-gradient(to top, rgba(0,0,0,.9) 0%, transparent 100%);
        }
        .collection-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem; color: white; margin-bottom: .4rem;
        }
        .collection-desc {
            font-size: .82rem; color: rgba(255,255,255,.7);
            font-weight: 300; margin-bottom: 1.25rem;
            max-height: 0; overflow: hidden;
            transition: max-height .5s ease, opacity .5s ease; opacity: 0;
        }
        .collection-card:hover .collection-desc { max-height: 60px; opacity: 1; }
        .collection-link {
            color: #cda274; font-size: .7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .12em;
            text-decoration: none; display: inline-flex; align-items: center; gap: .3rem;
            transition: color .3s;
        }
        .collection-link:hover { color: white; }
        .collections-cta {
            text-align: center; margin-top: 3rem;
        }
        .btn-outline-gold {
            display: inline-block;
            border: 1px solid #cda274; color: #cda274;
            padding: .85rem 2.5rem;
            font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .15em;
            text-decoration: none;
            transition: all .3s;
        }
        .btn-outline-gold:hover { background: #cda274; color: white; }

        @media(max-width: 900px) {
            .collections-grid { grid-template-columns: 1fr; }
            .collection-card { height: 380px; }
        }

        /* ── VALUES ── */
        .values-section {
            padding: 7rem 2rem;
            background: #f9f8f6;
        }
        .values-grid {
            max-width: 1100px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;
        }
        .value-card {
            background: white; padding: 2.5rem 1rem;
            display: flex; flex-direction: column; align-items: center;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
            transition: box-shadow .3s;
        }
        .value-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.1); }
        .value-icon {
            color: #cda274; font-size: 2rem; margin-bottom: 1rem;
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
        }
        .value-name {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; color: #374151;
        }

        @media(max-width: 768px) {
            .values-grid { grid-template-columns: repeat(2, 1fr); }
        }

        /* ── OBJECTIVES ── */
        .objectives-section {
            background: white;
        }
        .objectives-inner {
            max-width: 1300px; margin: 0 auto;
            display: flex;
        }
        .objectives-text {
            flex: 1; padding: 6rem 4rem 6rem 2rem;
            background: #fbf9f6;
            display: flex; flex-direction: column; justify-content: center;
        }
        .objectives-image {
            flex: 1; min-height: 500px;
        }
        .objectives-image img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        .check-list { list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem; }
        .check-list li {
            display: flex; align-items: flex-start; gap: .75rem;
            font-size: .9rem; color: #4b5563; font-weight: 300;
        }
        .check-icon {
            color: #cda274; flex-shrink: 0; margin-top: .15rem;
            font-size: 1rem;
        }

        @media(max-width: 900px) {
            .objectives-inner { flex-direction: column; }
            .objectives-text { padding: 4rem 2rem; }
            .objectives-image { min-height: 300px; }
        }

        /* ── BENEFICIARIES ── */
        .beneficiaries-section {
            padding: 7rem 2rem;
            background: #111;
        }
        .beneficiaries-grid {
            max-width: 1100px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;
            margin-top: 4rem;
        }
        .benefit-card {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            padding: 3rem 2rem;
            text-align: center;
            transition: background .3s;
        }
        .benefit-card:hover { background: rgba(255,255,255,.1); }
        .benefit-line {
            width: 3rem; height: 2px; background: #cda274;
            margin: 0 auto 1.5rem;
        }
        .benefit-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem; color: white; margin-bottom: 1rem;
        }
        .benefit-desc {
            font-size: .85rem; color: #9ca3af;
            font-weight: 300; font-style: italic;
        }

        @media(max-width: 768px) {
            .beneficiaries-grid { grid-template-columns: 1fr; }
        }

        /* ── FOOTER ── */
        .footer {
            background: #1a1a1a;
            padding: 5rem 2rem 2rem;
        }
        .footer-inner {
            max-width: 1300px; margin: 0 auto;
        }
        .footer-grid {
            display: grid; grid-template-columns: 1.2fr 1fr 1fr 1.2fr;
            gap: 3rem; margin-bottom: 3.5rem;
            padding-bottom: 3.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem; color: #cda274; letter-spacing: .12em;
            margin-bottom: 1.25rem; display: block;
        }
        .footer-desc {
            font-size: .85rem; color: #6b7280;
            font-weight: 300; line-height: 1.8; margin-bottom: 1.5rem;
        }
        .footer-social {
            display: flex; gap: .75rem;
        }
        .social-btn {
            width: 34px; height: 34px; border-radius: 50%;
            background: rgba(255,255,255,.05);
            display: flex; align-items: center; justify-content: center;
            color: #6b7280; text-decoration: none; font-size: .9rem;
            transition: all .3s;
        }
        .social-btn:hover { background: #cda274; color: white; }
        .footer-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; color: white; margin-bottom: 1.5rem;
        }
        .footer-links { display: flex; flex-direction: column; gap: .75rem; }
        .footer-link {
            color: #6b7280; text-decoration: none;
            font-size: .85rem; font-weight: 300;
            display: flex; align-items: center; gap: .4rem;
            transition: color .3s;
        }
        .footer-link:hover { color: #cda274; }
        .footer-contact-item {
            display: flex; align-items: flex-start; gap: .75rem;
            font-size: .85rem; color: #6b7280; font-weight: 300;
            margin-bottom: 1rem;
        }
        .footer-contact-icon { color: #cda274; flex-shrink: 0; margin-top: .15rem; }
        .footer-quote {
            border-left: 2px solid #cda274; padding-left: 1rem;
            font-style: italic; color: #6b7280;
            font-size: .85rem; font-weight: 300; margin-bottom: 1.5rem;
        }
        .newsletter-wrap { position: relative; }
        .newsletter-input {
            width: 100%; background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            color: white; padding: .85rem 3rem .85rem 1rem;
            font-size: .85rem;
            outline: none; transition: border-color .3s;
            font-family: 'Poppins', sans-serif;
        }
        .newsletter-input:focus { border-color: #cda274; }
        .newsletter-btn {
            position: absolute; right: 0; top: 0; height: 100%;
            background: #cda274; border: none; color: white;
            padding: 0 1rem; cursor: pointer; transition: background .3s;
            font-size: 1.1rem;
        }
        .newsletter-btn:hover { background: #b88e62; }
        .footer-bottom {
            display: flex; flex-wrap: wrap; justify-content: space-between;
            align-items: center; gap: 1rem;
        }
        .footer-copy {
            font-size: .78rem; color: #4b5563; font-weight: 300;
        }
        .footer-legal { display: flex; gap: 1.5rem; }
        .footer-legal a {
            font-size: .78rem; color: #4b5563;
            text-decoration: none; transition: color .3s;
        }
        .footer-legal a:hover { color: white; }

        @media(max-width: 900px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media(max-width: 600px) {
            .footer-grid { grid-template-columns: 1fr; }
        }

        /* ── CONTACT MODAL ── */
        .modal-overlay {
            display: none; position: fixed; inset: 0; z-index: 5000;
            background: rgba(0,0,0,.85); backdrop-filter: blur(8px);
            overflow-y: auto;
        }
        .modal-overlay.open { display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .modal-inner {
            position: relative; width: 100%; max-width: 1100px;
            display: flex; flex-wrap: wrap; gap: 3rem;
            align-items: flex-start;
        }
        .modal-close {
            position: absolute; top: -3rem; right: 0;
            background: none; border: none; color: rgba(255,255,255,.6);
            font-size: 2rem; cursor: pointer; transition: color .3s; line-height: 1;
        }
        .modal-close:hover { color: white; }
        .modal-left { flex: 1; min-width: 280px; color: white; }
        .modal-badge {
            display: inline-block;
            border: 1px solid rgba(205,162,116,.4); background: rgba(205,162,116,.1);
            color: #cda274; font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .2em;
            padding: .35rem .9rem; border-radius: 999px; margin-bottom: 1.5rem;
        }
        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3.2rem);
            line-height: 1.2; margin-bottom: 1.25rem;
        }
        .modal-title em { color: #cda274; }
        .modal-desc { color: #9ca3af; font-weight: 300; line-height: 1.8; margin-bottom: 2rem; }
        .modal-contact-cards { display: flex; flex-direction: column; gap: .75rem; }
        .modal-contact-card {
            background: #1a1a1a; border: 1px solid rgba(255,255,255,.08);
            padding: 1.25rem; display: flex; align-items: flex-start; gap: 1rem;
        }
        .modal-contact-card.full { }
        .modal-contact-icon-wrap {
            background: #111; border: 1px solid rgba(255,255,255,.08);
            padding: .75rem; color: #cda274; flex-shrink: 0;
        }
        .modal-contact-label {
            font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .15em;
            color: #6b7280; margin-bottom: .25rem;
        }
        .modal-contact-value { font-size: .85rem; color: #d1d5db; font-weight: 300; }
        .modal-right { flex: 1; min-width: 280px; }
        .modal-form-wrap {
            background: #1a1a1a; border: 1px solid rgba(255,255,255,.08);
            padding: 2.5rem;
        }
        .modal-form-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem; color: white; margin-bottom: .35rem;
        }
        .modal-form-sub { font-size: .82rem; color: #6b7280; font-weight: 300; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block; font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .15em;
            color: #6b7280; margin-bottom: .5rem;
        }
        .form-input, .form-textarea {
            width: 100%; background: #111;
            border: 1px solid rgba(255,255,255,.08);
            color: white; padding: .9rem 1rem;
            font-size: .875rem; font-weight: 300;
            font-family: 'Poppins', sans-serif;
            outline: none; transition: border-color .3s;
        }
        .form-input:focus, .form-textarea:focus { border-color: #cda274; }
        .form-textarea { resize: none; }
        .form-submit {
            width: 100%; background: #cda274; color: white;
            border: none; padding: 1rem;
            font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .15em;
            cursor: pointer; transition: background .3s;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            font-family: 'Poppins', sans-serif; margin-top: .5rem;
        }
        .form-submit:hover { background: #b88e62; }
    </style>
</head>
<body>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <button class="mobile-menu-close" onclick="closeMobileMenu()">&#10005;</button>
        <a href="{{ route('home') }}" class="mobile-nav-link">Inicio</a>
        <a href="#nosotros" class="mobile-nav-link" onclick="closeMobileMenu()">Acerca De</a>
        <a href="#colecciones" class="mobile-nav-link" onclick="closeMobileMenu()">Colecciones</a>
        <button onclick="closeMobileMenu(); openContactModal();" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Contacto</button>
        @if(auth()->check() && (auth()->user()->is_admin_global || auth()->user()->modules()->exists()))
            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-btn">Panel Admin</a>
        @else
            <a href="{{ route('login') }}" class="mobile-nav-btn">Ingresar</a>
        @endif
    </div>

    <!-- Navbar -->
    <header class="header" id="header">
        <div class="nav-wrapper">
            <a href="{{ route('home') }}" class="logo">WARAS</a>
            <nav class="desktop-nav">
                <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                <a href="#nosotros" class="nav-link">Acerca De</a>
                <a href="#colecciones" class="nav-link">Colecciones</a>
                <button onclick="openContactModal()" class="nav-link" style="background:none;border:none;cursor:pointer;font-family:'Poppins',sans-serif;">Contacto</button>
                @if(auth()->check() && (auth()->user()->is_admin_global || auth()->user()->modules()->exists()))
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin">Panel Admin</a>
                    <a href="{{ route('logout') }}" class="btn-login"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
                @endif
            </nav>
            <button class="hamburger-btn" onclick="openMobileMenu()" aria-label="Abrir menú">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero-section" id="inicio">
        <div class="hero-bg" style="background-image: url('{{ $heroBg }}')"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <p class="hero-eyebrow">Asociación de Ciencia y Cultura</p>
            <h1 class="hero-title">PORTAL UNIFICADO<br>EN ÁNCASH</h1>
            <p class="hero-subtitle">"Descubre nuestras colecciones de libros, fotos, música, artes y eventos históricos que preservan la memoria de nuestra región."</p>
            <a href="#colecciones" class="hero-cta">Explorar Servicios</a>
        </div>
        <div class="scroll-indicator">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 9l7 7 7-7"/></svg>
        </div>
    </section>

    <!-- About -->
    <section class="about-section" id="nosotros">
        <div class="about-inner">
            <div class="about-images">
                <img class="about-img-1"
                     src="https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?auto=format&fit=crop&w=600&q=80"
                     alt="Naturaleza Áncash">
                <img class="about-img-2"
                     src="https://images.unsplash.com/photo-1533601017-dc61895e03c0?auto=format&fit=crop&w=600&q=80"
                     alt="Cultura Áncash">
            </div>
            <div>
                <p class="about-eyebrow">Asociación Waras: Ciencia y Cultura</p>
                <h2 class="about-title">Protegiendo la Identidad Cultural de Áncash</h2>
                <p class="about-text">Nacimos ante el vacío estructural e histórico del Estado en la protección de la identidad cultural. Un grupo de ciudadanos conscientes decidió aportar para viabilizar el progreso sostenido de Áncash.</p>
                <p class="about-text">Áncash es una región privilegiada, con una profunda tradición cultural que subsiste a través del tiempo. Este portal digital es uno de los espacios que construimos para sistematizar, preservar y difundir el conocimiento.</p>
                <div class="about-boxes">
                    <div class="about-box">
                        <h4>Desarrollo Regional</h4>
                        <p>Contribuir al Desarrollo Económico y Social del Departamento.</p>
                    </div>
                    <div class="about-box">
                        <h4>Preservación</h4>
                        <p>Preservar y Difundir la Cultura Ancashina al mundo entero.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Collections -->
    <section class="collections-section" id="colecciones">
        <div class="section-header">
            <p class="section-eyebrow">Nuestro Acervo Cultural</p>
            <h2 class="section-title">Explora Nuestras Colecciones</h2>
        </div>
        <div class="collections-grid">
            <!-- Biblioteca -->
            <div class="collection-card">
                <img class="collection-img"
                     src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=900&q=80"
                     alt="Biblioteca">
                <div class="collection-tag">Operativo</div>
                <div class="collection-bottom">
                    <h3 class="collection-title">Biblioteca</h3>
                    <p class="collection-desc">Colección completa de libros y publicaciones.</p>
                    <a href="{{ route('biblioteca.dashboard') }}" class="collection-link">Explorar ›</a>
                </div>
            </div>
            <!-- Fototeca -->
            <div class="collection-card">
                <img class="collection-img"
                     src="https://images.unsplash.com/photo-1452830978618-d6feae7d0faa?auto=format&fit=crop&w=900&q=80"
                     alt="Fototeca">
                <div class="collection-tag">Operativo</div>
                <div class="collection-bottom">
                    <h3 class="collection-title">Fototeca</h3>
                    <p class="collection-desc">Archivo fotográfico y memoria visual de la región.</p>
                    <a href="{{ route('fototeca.inicio') }}" class="collection-link">Explorar ›</a>
                </div>
            </div>
            <!-- Musicoteca -->
            <div class="collection-card">
                <img class="collection-img"
                     src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=900&q=80"
                     alt="Musicoteca">
                <div class="collection-tag">En Desarrollo</div>
                <div class="collection-bottom">
                    <h3 class="collection-title">Musicoteca</h3>
                    <p class="collection-desc">Composiciones y géneros musicales ancashinos.</p>
                    <span class="collection-link" style="cursor:default;opacity:.6;">Próximamente ›</span>
                </div>
            </div>
        </div>
        <div class="collections-cta">
            <a href="#colecciones" class="btn-outline-gold">Ver Catálogo Completo</a>
        </div>
    </section>

    <!-- Values -->
    <section class="values-section">
        <div class="section-header">
            <p class="section-eyebrow">Nuestros Pilares</p>
            <h2 class="section-title">Valores Institucionales</h2>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">⚖️</div>
                <span class="value-name">Equidad</span>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <span class="value-name">Fraternidad</span>
            </div>
            <div class="value-card">
                <div class="value-icon">💛</div>
                <span class="value-name">Solidaridad</span>
            </div>
            <div class="value-card">
                <div class="value-icon">🌿</div>
                <span class="value-name">Armonía</span>
            </div>
            <div class="value-card">
                <div class="value-icon">🕊️</div>
                <span class="value-name">Libertad</span>
            </div>
        </div>
    </section>

    <!-- Objectives -->
    <section class="objectives-section">
        <div class="objectives-inner">
            <div class="objectives-text">
                <p class="about-eyebrow">Plan de Acción</p>
                <h2 class="about-title">Objetivos Específicos</h2>
                <p class="about-text" style="font-style:italic;">Nuestras metas a corto y largo plazo para asegurar el impacto positivo en la región.</p>
                <ul class="check-list">
                    <li><span class="check-icon">✓</span> Promover e impulsar las ciencias, arte, identidad y cultura.</li>
                    <li><span class="check-icon">✓</span> Fomentar la investigación y capacitación educativa, artística y cultural.</li>
                    <li><span class="check-icon">✓</span> Ejecutar proyectos que desarrollen capacidades científicas y tecnológicas.</li>
                    <li><span class="check-icon">✓</span> Promover la ciudadanía activa y la participación cívica.</li>
                </ul>
            </div>
            <div class="objectives-image">
                <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=900&q=80"
                     alt="Montañas Áncash">
            </div>
        </div>
    </section>

    <!-- Beneficiaries -->
    <section class="beneficiaries-section">
        <div style="text-align:center;">
            <p class="section-eyebrow">Impacto Social</p>
            <h2 class="section-title" style="color:white;">Nuestros Beneficiarios</h2>
        </div>
        <div class="beneficiaries-grid">
            <div class="benefit-card">
                <div class="benefit-line"></div>
                <h4 class="benefit-title">Estudiantes</h4>
                <p class="benefit-desc">"Nivel primaria, secundaria y superior de toda la región de Áncash."</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-line"></div>
                <h4 class="benefit-title">Comunidad Educativa</h4>
                <p class="benefit-desc">"Docentes de nivel básico y superior, así como investigadores."</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-line"></div>
                <h4 class="benefit-title">Sociedad Civil</h4>
                <p class="benefit-desc">"Autoridades, empresarios, inversores y turistas internacionales."</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contacto-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <!-- Logo & desc -->
                <div>
                    <span class="footer-logo">WARAS</span>
                    <p class="footer-desc">Portal integrado de acceso a colecciones de ciencia, cultura y patrimonio. Preservando la memoria de nuestra región.</p>
                    <div class="footer-social">
                        <a href="#" class="social-btn" aria-label="Facebook">f</a>
                        <a href="#" class="social-btn" aria-label="Twitter">t</a>
                        <a href="#" class="social-btn" aria-label="Instagram">in</a>
                    </div>
                </div>
                <!-- Links -->
                <div>
                    <h4 class="footer-heading">Explorar</h4>
                    <div class="footer-links">
                        <a href="#colecciones" class="footer-link">› Servicios</a>
                        <a href="#nosotros" class="footer-link">› Acerca de</a>
                        <a href="{{ route('biblioteca.dashboard') }}" class="footer-link">› Biblioteca</a>
                        <a href="{{ route('fototeca.inicio') }}" class="footer-link">› Fototeca</a>
                    </div>
                </div>
                <!-- Contact -->
                <div>
                    <h4 class="footer-heading">Contacto</h4>
                    <div class="footer-contact-item">
                        <span class="footer-contact-icon">📍</span>
                        <span>Esq. Av. Luzuriaga con Av. 28 de Julio<br>Huaraz, Áncash, Perú</span>
                    </div>
                    <div class="footer-contact-item">
                        <span class="footer-contact-icon">📞</span>
                        <span>+51 952-845-942</span>
                    </div>
                    <div class="footer-contact-item">
                        <span class="footer-contact-icon">✉️</span>
                        <span>giber.garcia@pcca.org</span>
                    </div>
                </div>
                <!-- Newsletter -->
                <div>
                    <h4 class="footer-heading">Principios Incas</h4>
                    <blockquote class="footer-quote">"Ama Llulla, Ama Quella, Ama Sua"</blockquote>
                    <div class="newsletter-wrap">
                        <input type="email" class="newsletter-input" placeholder="Suscríbete al boletín...">
                        <button class="newsletter-btn">›</button>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-copy">Copyright © 2024 WARAS - Asociación de Ciencia y Cultura Ancashina.</p>
                <div class="footer-legal">
                    <a href="#">Política de Privacidad</a>
                    <a href="#">Términos de Uso</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Contact Modal -->
    <div class="modal-overlay" id="contactModal">
        <div class="modal-inner">
            <button class="modal-close" onclick="closeContactModal()">&#10005;</button>
            <!-- Left info -->
            <div class="modal-left">
                <span class="modal-badge">Contacto Directo</span>
                <h2 class="modal-title">Si está interesado en nuestra labor, <em>póngase en contacto.</em></h2>
                <p class="modal-desc">El proceso es simple, solo tiene que llenar el formulario y enviar. También cuenta con información más específica como correos y números telefónicos a continuación.</p>
                <div class="modal-contact-cards">
                    <div class="modal-contact-card full">
                        <div class="modal-contact-icon-wrap">📍</div>
                        <div>
                            <p class="modal-contact-label">Dirección</p>
                            <p class="modal-contact-value">Esq. Av. Luzuriaga con Av. 28 de Julio<br>Huaraz, Áncash, Perú</p>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                        <div class="modal-contact-card">
                            <div class="modal-contact-icon-wrap">📞</div>
                            <div>
                                <p class="modal-contact-label">Teléfonos</p>
                                <p class="modal-contact-value">952 845 942</p>
                            </div>
                        </div>
                        <div class="modal-contact-card">
                            <div class="modal-contact-icon-wrap">✉️</div>
                            <div>
                                <p class="modal-contact-label">Email</p>
                                <p class="modal-contact-value" style="word-break:break-all;">giber.garcia@pcca.org</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right form -->
            <div class="modal-right">
                <div class="modal-form-wrap">
                    <h3 class="modal-form-title">Envíenos un mensaje</h3>
                    <p class="modal-form-sub">Responderemos lo más pronto posible.</p>
                    <form action="mailto:giber.garcia@pcca.org" method="GET">

                        <div class="form-group">
                            <label class="form-label">Nombres Completos</label>
                            <input type="text" name="name" class="form-input" placeholder="Ej. Juan Pérez" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-input" placeholder="ejemplo@correo.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mensaje</label>
                            <textarea name="message" class="form-textarea" rows="4" placeholder="Escriba su consulta o comentario aquí..." required></textarea>
                        </div>
                        <button type="submit" class="form-submit">Enviar Mensaje &#10148;</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navbar scroll
        window.addEventListener('scroll', () => {
            document.getElementById('header').classList.toggle('scrolled', window.scrollY > 50);
        });

        // Mobile menu
        function openMobileMenu()  { document.getElementById('mobileMenu').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeMobileMenu() { document.getElementById('mobileMenu').classList.remove('open'); document.body.style.overflow = ''; }
        window.openMobileMenu  = openMobileMenu;
        window.closeMobileMenu = closeMobileMenu;

        // Contact modal
        function openContactModal()  { document.getElementById('contactModal').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeContactModal() { document.getElementById('contactModal').classList.remove('open'); document.body.style.overflow = ''; }
        window.openContactModal  = openContactModal;
        window.closeContactModal = closeContactModal;
        document.getElementById('contactModal').addEventListener('click', function(e) {
            if (e.target === this) closeContactModal();
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function(e) {
                const id = this.getAttribute('href').slice(1);
                const el = document.getElementById(id);
                if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
            });
        });
    </script>
    <x-floating-buttons />
</body>
</html>
