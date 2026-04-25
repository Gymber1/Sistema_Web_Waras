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
            background: rgba(10,10,10,0.97);
            backdrop-filter: blur(12px);
            padding: 0.75rem 0;
            box-shadow: 0 2px 24px rgba(0,0,0,0.6);
            border-bottom: 1px solid rgba(255,255,255,0.06);
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

        /* ── HERO SLIDER ── */
        .hero-section {
            position: relative; height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .hero-slide-bg {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            background-size: 110%;
            background-position: center;
            background-repeat: no-repeat;
            animation: kenBurns 8s cubic-bezier(0.3, 0, 0.7, 1) forwards;
        }
        @keyframes kenBurns {
            from { transform: scale(1) translateZ(0); }
            to { transform: scale(1.05) translateZ(0); }
        }
        .hero-overlay { 
            position: absolute; inset: 0; 
            background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.6) 50%, rgba(0,0,0,0.4) 100%);
            mix-blend-mode: multiply;
        }
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
            padding: 6rem 0 5rem;
            background: white;
            overflow: hidden;
        }
        .section-header {
            text-align: center; max-width: 600px;
            margin: 0 auto 4rem; padding: 0 2rem;
        }
        .section-eyebrow {
            color: #C8A97E; font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .3em;
            margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            color: #111827;
        }

        /* Slider full-width */
        .collections-wrapper {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: 2.5rem 0;
        }
        .collections-carousel-container {
            position: relative;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            overflow: hidden;
        }
        .collections-carousel {
            display: flex;
            gap: 2rem;
            align-items: center;
            will-change: transform;
            transition: transform 1500ms ease-in-out;
        }

        /* Cards al estilo pro.txt — sin border-radius, efecto escala */
        .collection-card {
            position: relative;
            height: 500px;
            width: 420px;
            overflow: hidden;
            background: #111;
            cursor: pointer;
            flex-shrink: 0;
            transition: transform 1500ms ease-in-out, opacity 1500ms ease-in-out, box-shadow 0.3s ease;
            transform-origin: center;
        }
        .collection-card.inactive {
            transform: scale(0.85);
            opacity: 0.4;
        }
        .collection-card.active {
            transform: scale(1);
            opacity: 1;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            z-index: 2;
        }
        .collection-img {
            position: absolute; inset: 0;
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 2000ms ease;
        }
        .collection-card:hover .collection-img { transform: scale(1.08); }
        .collection-gradient {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.1) 100%);
        }
        .collection-tag {
            position: absolute; top: 1.5rem; right: 1.5rem;
            border: 1px solid rgba(255,255,255,.35);
            background: rgba(0,0,0,.4); backdrop-filter: blur(6px);
            padding: .6rem .5rem;
            writing-mode: vertical-rl; transform: rotate(180deg);
            color: white; font-size: .6rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .25em;
        }
        .collection-bottom {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 2rem 2rem 2.5rem;
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.7s ease 0.1s, transform 0.7s ease 0.1s;
        }
        .collection-card.active .collection-bottom {
            opacity: 1;
            transform: translateY(0);
        }
        .collection-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem; color: white; margin-bottom: .35rem;
        }
        .collection-type {
            font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .2em;
            color: #C8A97E;
        }

        /* Controles */
        .carousel-controls {
            display: flex; flex-direction: column;
            align-items: center; gap: 2rem;
            margin-top: 2rem;
        }
        .carousel-controls-row {
            display: flex; align-items: center; gap: 1.5rem;
        }
        .carousel-btn {
            background: #C8A97E; color: white; border: none;
            width: 42px; height: 42px; border-radius: 50%;
            cursor: pointer; transition: all .2s;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; font-weight: 700;
            box-shadow: 0 4px 12px rgba(200,169,126,0.35);
        }
        .carousel-btn:hover { background: #b3956d; transform: scale(1.08); }
        .carousel-dots {
            display: flex; gap: .6rem; align-items: center;
        }
        .carousel-dot {
            height: 8px; border-radius: 4px;
            background: #cbd5e1; cursor: pointer; transition: all .4s;
            width: 8px;
        }
        .carousel-dot.active {
            background: #C8A97E; width: 32px;
        }
        .collections-cta {
            text-align: center;
        }
        .btn-outline-gold {
            display: inline-block;
            border: 1px solid #C8A97E; color: #C8A97E;
            padding: .9rem 2.5rem;
            font-size: .7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .2em;
            text-decoration: none;
            transition: all .25s;
            border-radius: 2px;
        }
        .btn-outline-gold:hover { background: #C8A97E; color: white; }

        @media(max-width: 768px) {
            .collection-card { height: 400px; width: 300px; }
            .carousel-btn { width: 36px; height: 36px; font-size: 1rem; }
        }

        /* ── ORGANIZACIÓN ── */
        .org-section { padding: 6rem 2rem; background: #f9f8f6; }
        .org-inner {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
        }
        .org-img-wrap {
            position: relative;
        }
        .org-img-shadow {
            position: absolute; inset: 0;
            background: #cda274; border-radius: 16px;
            transform: translate(14px, 14px);
            opacity: 0.2;
            transition: transform .5s ease;
        }
        .org-img-wrap:hover .org-img-shadow { transform: translate(20px, 20px); }
        .org-img-clip {
            position: relative; z-index: 1;
            width: 100%; aspect-ratio: 4/3;
            border-radius: 16px;
            overflow: hidden;
            background: #1a1a1a;
            display: flex; align-items: center; justify-content: center;
        }
        .org-img {
            width: 100%; height: 100%; object-fit: contain;
            display: block;
            filter: grayscale(1);
            transition: filter .7s ease;
        }
        .org-img-wrap:hover .org-img { filter: grayscale(0); }
        .org-img-label {
            position: absolute; bottom: 1.5rem; left: 1.5rem; z-index: 2;
            background: rgba(255,255,255,.92); backdrop-filter: blur(8px);
            padding: .55rem 1.25rem; border-radius: 6px;
            font-size: .65rem; font-weight: 700; color: #cda274;
            text-transform: uppercase; letter-spacing: .18em;
        }
        .org-eyebrow {
            display: flex; align-items: center; gap: .75rem; margin-bottom: 1.25rem;
        }
        .org-eyebrow-icon {
            width: 32px; height: 32px; background: rgba(205,162,116,.12);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: .9rem;
        }
        .org-eyebrow-text {
            font-size: .65rem; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: .2em;
        }
        .org-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 3vw, 2.7rem);
            color: #111; line-height: 1.2; margin-bottom: 1.5rem;
        }
        .org-title em { color: #cda274; font-style: italic; }
        .org-text {
            color: #6b7280; font-size: .92rem; font-weight: 300;
            line-height: 1.9; margin-bottom: .9rem;
        }
        .org-text strong { color: #374151; font-weight: 500; }
        @media(max-width: 900px) {
            .org-inner { grid-template-columns: 1fr; gap: 3rem; }
        }

        /* Finalidad + Objetivo General */
        .org-cards-section { background: white; padding: 5rem 2rem; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; }
        .org-cards-inner { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .org-card {
            padding: 2.5rem; border-radius: 20px; transition: box-shadow .3s;
        }
        .org-card:hover { box-shadow: 0 12px 32px rgba(0,0,0,.08); }
        .org-card-light { background: #f4f9f9; border: 1px solid rgba(205,162,116,.2); }
        .org-card-dark { background: #1a3a3c; color: white; position: relative; overflow: hidden; }
        .org-card-dark::before {
            content: ''; position: absolute; right: -2rem; top: -2rem;
            width: 120px; height: 120px; background: rgba(255,255,255,.06);
            border-radius: 50%; filter: blur(20px);
        }
        .org-card-icon {
            width: 44px; height: 44px; border-radius: 10px; margin-bottom: 1.25rem;
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
        }
        .org-card-icon-light { background: white; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .org-card-icon-dark { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.2); }
        .org-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem; margin-bottom: 1rem;
        }
        .org-card-light .org-card-title { color: #111; }
        .org-card-dark .org-card-title { color: white; position: relative; z-index: 1; }
        .org-card-text { font-size: .875rem; line-height: 1.8; color: #6b7280; }
        .org-card-list { list-style: none; display: flex; flex-direction: column; gap: .85rem; position: relative; z-index: 1; }
        .org-card-list li { display: flex; align-items: flex-start; gap: .65rem; font-size: .875rem; color: rgba(255,255,255,.8); font-weight: 300; line-height: 1.6; }
        .org-card-list-arrow { color: #cda274; flex-shrink: 0; margin-top: .1rem; }
        @media(max-width: 768px) { .org-cards-inner { grid-template-columns: 1fr; } }

        /* Líneas de trabajo */
        .org-lines-section { padding: 6rem 2rem; background: #f9f8f6; }
        .org-lines-inner { max-width: 1100px; margin: 0 auto; }
        .org-lines-header { text-align: center; margin-bottom: 4rem; }
        .org-lines-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 2.5vw, 2.2rem); color: #111; margin-bottom: .75rem;
        }
        .org-lines-sub { font-size: .85rem; color: #9ca3af; max-width: 560px; margin: 0 auto; line-height: 1.7; }
        .org-lines-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; }
        .org-lines-col-label {
            font-size: .62rem; font-weight: 700; color: #cda274;
            text-transform: uppercase; letter-spacing: .22em;
            border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; margin-bottom: 1.5rem;
        }
        .org-lines-list { list-style: none; display: flex; flex-direction: column; gap: .5rem; }
        .org-lines-item {
            display: flex; align-items: flex-start; gap: .85rem;
            padding: .75rem 1rem; border-radius: 10px; border: 1px solid transparent;
            transition: all .25s; font-size: .855rem; color: #4b5563; font-weight: 300; line-height: 1.5;
        }
        .org-lines-item:hover { background: white; border-color: #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,.05); }
        .org-lines-check {
            width: 22px; height: 22px; background: rgba(205,162,116,.1);
            border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
            margin-top: .1rem; font-size: .65rem; color: #cda274;
        }
        .org-beneficiaries-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
        .org-beneficiary-item {
            background: white; border: 1px solid #e5e7eb; border-radius: 10px;
            padding: .85rem 1rem; display: flex; align-items: center; gap: .7rem;
            font-size: .82rem; color: #374151; font-weight: 500;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .org-beneficiary-dot { width: 8px; height: 8px; border-radius: 50%; background: #cda274; flex-shrink: 0; }
        @media(max-width: 768px) {
            .org-lines-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .org-beneficiaries-grid { grid-template-columns: 1fr; }
        }

        /* ── PREMIOS ── */
        .premios-hero {
            background: #0f2628; padding: 5rem 2rem 8rem;
            text-align: center;
        }
        .premios-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .45rem 1.1rem; border-radius: 999px;
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15);
            margin-bottom: 2rem;
        }
        .premios-badge-icon { color: #cda274; font-size: .8rem; }
        .premios-badge-text {
            font-size: .6rem; font-weight: 700; color: white;
            text-transform: uppercase; letter-spacing: .2em;
        }
        .premios-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.7rem, 3.5vw, 3rem); color: white;
            max-width: 800px; margin: 0 auto 1.5rem; line-height: 1.25;
        }
        .premios-title em { color: #cda274; font-style: italic; }
        .premios-subtitle {
            font-size: .95rem; color: rgba(255,255,255,.65); font-weight: 300;
            max-width: 680px; margin: 0 auto; line-height: 1.8;
        }

        .premios-video-wrap {
            max-width: 960px; margin: -4rem auto 0; padding: 0 2rem;
        }
        .premios-video {
            position: relative; width: 100%; aspect-ratio: 16/9;
            background: #0a0a0a; border-radius: 16px; overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,.45);
            border: 3px solid white; cursor: pointer;
        }
        .premios-video-bg {
            width: 100%; height: 100%; object-fit: cover; opacity: .55;
            transition: transform .7s ease;
        }
        .premios-video:hover .premios-video-bg { transform: scale(1.04); }
        .premios-video-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,.85) 0%, rgba(0,0,0,.15) 60%, transparent 100%);
        }
        .premios-video-play {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .premios-play-btn {
            width: 72px; height: 50px; background: #e00; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            transition: background .25s;
        }
        .premios-video:hover .premios-play-btn { background: #c00; }
        .premios-play-triangle {
            width: 0; height: 0;
            border-top: 11px solid transparent;
            border-bottom: 11px solid transparent;
            border-left: 20px solid white;
            margin-left: 4px;
        }
        .premios-video-info {
            position: absolute; bottom: 1.5rem; left: 2rem; right: 2rem;
            display: flex; justify-content: space-between; align-items: flex-end;
        }
        .premios-video-name { font-size: 1.3rem; font-weight: 700; color: white; }
        .premios-video-role { font-size: .7rem; color: rgba(255,255,255,.7); text-transform: uppercase; letter-spacing: .15em; margin-top: .2rem; }
        .premios-video-yt {
            background: rgba(0,0,0,.5); backdrop-filter: blur(8px);
            padding: .45rem .9rem; border-radius: 8px;
            font-size: .7rem; color: white; font-weight: 700; letter-spacing: .05em;
        }

        .premios-reconocimiento {
            max-width: 960px; margin: 3rem auto 5rem; padding: 0 2rem;
        }
        .premios-rec-card {
            background: white; border-radius: 20px; padding: 3.5rem 3rem;
            box-shadow: 0 4px 24px rgba(0,0,0,.07); border: 1px solid #f0ede9;
            display: flex; flex-direction: column; align-items: center; text-align: center;
        }
        .premios-rec-label {
            font-size: .62rem; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: .22em; margin-bottom: 2rem;
        }
        .premios-ministerio {
            display: flex; border-radius: 8px; overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,.12); border: 1px solid #e5e7eb;
        }
        .premios-ministerio-peru {
            background: #c8102e; color: white; padding: .9rem 1.5rem;
            display: flex; align-items: center; gap: .75rem;
        }
        .premios-ministerio-escudo {
            width: 28px; height: 28px; background: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .premios-ministerio-escudo-inner {
            width: 20px; height: 20px; border: 2px solid #c8102e; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 5px; font-weight: 900; color: #c8102e; letter-spacing: -.5px;
        }
        .premios-ministerio-peru-text { font-size: 1.15rem; font-weight: 900; letter-spacing: .05em; }
        .premios-ministerio-nombre {
            background: #1f2937; color: white; padding: .9rem 2rem;
            font-size: 1rem; font-weight: 600; letter-spacing: .03em;
            display: flex; align-items: center;
        }
        .premios-director {
            margin-top: 3rem; padding-top: 2.5rem; border-top: 1px solid #f0ede9;
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 1.25rem;
        }
        .premios-director-avatar {
            width: 56px; height: 56px; border-radius: 50%; object-fit: cover;
            border: 2px solid #cda274;
        }
        .premios-director-label {
            font-size: .62rem; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: .18em; margin-bottom: .3rem;
        }
        .premios-director-name { font-size: 1.1rem; font-weight: 700; color: #111; }
        @media(max-width: 640px) {
            .premios-director { flex-direction: column; }
            .premios-rec-card { padding: 2.5rem 1.5rem; }
            .premios-video-wrap, .premios-reconocimiento { padding: 0 1rem; }
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

        /* ── PAGE VIEWS ── */
        .page-view { animation: viewIn .45s ease both; }
        @keyframes viewIn { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }

        /* ── SUBVIEW HERO BANNER ── */
        .subview-hero {
            position: relative; height: 52vh; min-height: 360px;
            display: flex; align-items: center; justify-content: center;
            text-align: center; overflow: hidden;
        }
        .subview-hero-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
        }
        .subview-hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, rgba(10,10,10,.7) 0%, rgba(10,10,10,.55) 50%, #0f2628 100%);
        }
        .subview-hero-content {
            position: relative; z-index: 1; padding: 2rem; margin-top: 4rem;
            max-width: 700px;
        }
        .subview-hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .4rem 1rem; border-radius: 999px;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
            font-size: .6rem; font-weight: 700; color: white;
            text-transform: uppercase; letter-spacing: .18em;
            margin-bottom: 1.5rem;
        }
        .subview-hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            color: white; line-height: 1.15; margin-bottom: 1rem;
        }
        .subview-hero-sub {
            font-size: .95rem; color: rgba(255,255,255,.65);
            font-weight: 300; line-height: 1.7; max-width: 560px; margin: 0 auto;
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
        <a href="{{ route('home') }}" class="mobile-nav-link" onclick="showView('inicio');closeMobileMenu();return false;">Inicio</a>
        <button onclick="showView('inicio');closeMobileMenu();setTimeout(()=>{document.getElementById('colecciones')?.scrollIntoView({behavior:'smooth'})},50);" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Colecciones</button>
        <button onclick="showView('organizacion');closeMobileMenu();" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Organización</button>
        <button onclick="showView('premios');closeMobileMenu();" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Premios</button>
        <button onclick="showView('aportantes');closeMobileMenu();" class="mobile-nav-link" style="background:none;border:none;cursor:pointer;font-size:1.4rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;font-family:'Poppins',sans-serif;">Aportantes</button>
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
                <a href="{{ route('home') }}" class="nav-link" onclick="showView('inicio');return false;">Inicio</a>
                <a href="#colecciones" class="nav-link" onclick="showView('inicio');setTimeout(()=>{document.getElementById('colecciones')?.scrollIntoView({behavior:'smooth'})},50);return false;">Colecciones</a>
                <button onclick="showView('organizacion')" class="nav-link" style="background:none;border:none;cursor:pointer;font-family:'Poppins',sans-serif;">Organización</button>
                <button onclick="showView('premios')" class="nav-link" style="background:none;border:none;cursor:pointer;font-family:'Poppins',sans-serif;">Premios</button>
                <button onclick="showView('aportantes')" class="nav-link" style="background:none;border:none;cursor:pointer;font-family:'Poppins',sans-serif;">Aportantes</button>
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

    <!-- ===== VISTA: INICIO ===== -->
    <div id="view-inicio" class="page-view">

    <!-- Hero Slider -->
    <section class="hero-section" id="inicio">
        <div class="hero-slide-bg" style="background-image: url('{{ $heroBg }}');"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <p class="hero-eyebrow">Asociación de Ciencia y Cultura</p>
            <h1 class="hero-title">WARAS</h1>
            <p class="hero-subtitle">"Descubre nuestras colecciones de libros, fotos, música, artes y eventos históricos que preservan la memoria de nuestra región."</p>
            <a href="#colecciones" class="hero-cta">Explorar Servicios</a>
        </div>
        <div class="scroll-indicator">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 9l7 7 7-7"/></svg>
        </div>
    </section>



    <!-- Collections -->
    <section class="collections-section" id="colecciones">
        <div class="section-header">
            <p class="section-eyebrow">Nuestro Acervo Cultural</p>
            <h2 class="section-title">Explora Nuestras Colecciones</h2>
        </div>
        <div class="collections-wrapper">
            <div class="collections-carousel-container">
                <div class="collections-carousel" id="collectionsCarousel">
                    <!-- Biblioteca -->
                    <div class="collection-card" data-url="{{ route('biblioteca.dashboard') }}">
                        <img class="collection-img" src="{{ $heroBgBiblioteca }}" alt="Biblioteca">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Operativo</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Biblioteca</h3>
                            <p class="collection-type">Acceso Libre</p>
                        </div>
                    </div>
                    <!-- Fototeca -->
                    <div class="collection-card" data-url="{{ route('fototeca.inicio') }}">
                        <img class="collection-img" src="{{ $heroBgFototeca }}" alt="Fototeca">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Operativo</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Fototeca</h3>
                            <p class="collection-type">Acceso Libre</p>
                        </div>
                    </div>
                    <!-- Efemérides -->
                    <div class="collection-card">
                        <img class="collection-img" src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=900&q=80" alt="Efemérides">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Pronto</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Efemérides</h3>
                            <p class="collection-type">Próximamente</p>
                        </div>
                    </div>
                    <!-- Catálogo KOHA -->
                    <div class="collection-card">
                        <img class="collection-img" src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=900&q=80" alt="Catálogo KOHA">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Pronto</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Catálogo KOHA</h3>
                            <p class="collection-type">Próximamente</p>
                        </div>
                    </div>
                    <!-- Musicoteca -->
                    <div class="collection-card">
                        <img class="collection-img" src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=900&q=80" alt="Musicoteca">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Pronto</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Musicoteca</h3>
                            <p class="collection-type">Próximamente</p>
                        </div>
                    </div>
                    <!-- Pinacoteca -->
                    <div class="collection-card">
                        <img class="collection-img" src="https://images.unsplash.com/photo-1578301978162-7aae4d755744?auto=format&fit=crop&w=900&q=80" alt="Pinacoteca">
                        <div class="collection-gradient"></div>
                        <div class="collection-tag">Pronto</div>
                        <div class="collection-bottom">
                            <h3 class="collection-title">Pinacoteca</h3>
                            <p class="collection-type">Próximamente</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-controls">
                <div class="carousel-controls-row">
                    <button class="carousel-btn" id="prevBtn" onclick="scrollCarousel('prev')">‹</button>
                    <div class="carousel-dots" id="carouselDots"></div>
                    <button class="carousel-btn" id="nextBtn" onclick="scrollCarousel('next')">›</button>
                </div>
            </div>
        </div>
    </section>

    </div><!-- /view-inicio -->

    <!-- ===== VISTA: ORGANIZACIÓN ===== -->
    <div id="view-organizacion" class="page-view" style="display:none;">

    <!-- Hero Banner -->
    <section class="subview-hero">
        <div class="subview-hero-bg" style="background-image:url('{{ $heroBg }}');"></div>
        <div class="subview-hero-overlay"></div>
        <div class="subview-hero-content">
            <h1 class="subview-hero-title">Nuestra Organización</h1>
            <p class="subview-hero-sub">Conoce la misión, visión y los valores que impulsan la preservación del patrimonio regional.</p>
        </div>
    </section>

    <!-- ORGANIZACIÓN: Quiénes Somos -->
    <section class="org-section" id="organizacion">
        <div class="org-inner">
            <div class="org-img-wrap">
                <div class="org-img-shadow"></div>
                <div class="org-img-clip">
                    <img class="org-img"
                         src="/Fundadores.jpg"
                         alt="Fundadores Asociación Waras">
                </div>
                <span class="org-img-label">Fundadores de WARAS</span>
            </div>
            <div>
                <div class="org-eyebrow">
                    <span class="org-eyebrow-text">Quiénes Somos</span>
                </div>
                <h2 class="org-title">Asociación Waras:<br><em>Ciencia y Cultura</em></h2>
                <p class="org-text">La <strong>Asociación Waras: Ciencia y Cultura</strong> nació ante el vacío estructural e histórico del Estado en la protección de la identidad cultural.</p>
                <p class="org-text">Un grupo de ciudadanos conscientes de que la protección del Medio Ambiente, la Educación, la Cultura y la Investigación son el germen para un sólido Desarrollo Económico y Social decidió aportar para viabilizar el progreso sostenido de Áncash.</p>
                <p class="org-text">Áncash es una región privilegiada, con una profunda tradición cultural que subsiste a través del tiempo y una diversidad de recursos naturales únicos. Este portal digital es uno de los espacios que construimos para sistematizar, preservar y difundir el conocimiento.</p>
            </div>
        </div>
    </section>

    <!-- ORGANIZACIÓN: Finalidad + Objetivos -->
    <section class="org-cards-section">
        <div class="org-cards-inner">
            <div class="org-card org-card-light">
                <div class="">
                    <img src="/Nuestra_Finalidad.png" alt="Nuestra Finalidad" style="width:100px;height:50px;object-fit:contain;">
                </div>
                <h3 class="org-card-title">Nuestra Finalidad</h3>
                <p class="org-card-text">Promover estudios, investigaciones, capacitaciones, propuestas y espacios que aporten al desarrollo económico, social, ambiental, cultural, educacional, científico, tecnológico, y ciudadanía en el departamento de Áncash para la mejora de la calidad de vida de sus ciudadanos.</p>
            </div>
            <div class="org-card org-card-dark">
                <div class="">
                    <img src="/Objetivo_General.png" alt="Objetivo General" style="width:100px;height:50px;object-fit:contain;">
                </div>
                <h3 class="org-card-title">Objetivo General</h3>
                <ul class="org-card-list">
                    <li><span class="org-card-list-arrow">›</span> Contribuir al Desarrollo Económico y Social del Departamento de Ancash.</li>
                    <li><span class="org-card-list-arrow">›</span> Preservar y Difundir la Cultura Ancashina al mundo a través de plataformas digitales.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ORGANIZACIÓN: Líneas de trabajo + Beneficiarios -->
    <section class="org-lines-section">
        <div class="org-lines-inner">
            <div class="org-lines-header">
                <h2 class="org-lines-title">Líneas de Trabajo y Alcance</h2>
                <p class="org-lines-sub">Estrategias específicas orientadas a la investigación, desarrollo y preservación del acervo ancashino.</p>
            </div>
            <div class="org-lines-grid">
                <div>
                    <p class="org-lines-col-label">Objetivos Específicos</p>
                    <ul class="org-lines-list">
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Promover e impulsar las ciencias, arte, identidad, ciudadanía y cultura.</li>
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Promover la investigación y capacitación educativa, artística y ambiental.</li>
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Promover y ejecutar proyectos y programas que desarrollen capacidades científicas.</li>
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Lograr el desarrollo de nuestros fines en alianza y convenios con instituciones.</li>
                        <li class="org-lines-item"><span class="org-lines-check">✓</span> Desarrollar un Sistema y Portal de Información de alcance regional.</li>
                    </ul>
                </div>
                <div>
                    <p class="org-lines-col-label">Nuestros Beneficiarios</p>
                    <div class="org-beneficiaries-grid">
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Estudiantes de primaria y secundaria</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Estudiantes de nivel superior</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Docentes de nivel básico y superior</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Autoridades y partidos políticos</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Empresarios e inversores regionales</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Turistas nacionales e internacionales</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Población con interés en ciencia</div>
                        <div class="org-beneficiary-item"><span class="org-beneficiary-dot"></span> Investigadores culturales</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </div><!-- /view-organizacion -->

    <!-- ===== VISTA: PREMIOS ===== -->
    <div id="view-premios" class="page-view" style="display:none;">

    <!-- Hero Banner -->
    <section class="subview-hero">
        <div class="subview-hero-bg" style="background-image:url('{{ $heroBg }}');"></div>
        <div class="subview-hero-overlay"></div>
        <div class="subview-hero-content">
            <h1 class="subview-hero-title">Premios y Reconocimientos</h1>
            <p class="subview-hero-sub">Logros y respaldos institucionales que garantizan la calidad y sostenibilidad de nuestro proyecto.</p>
        </div>
    </section>

    <!-- PREMIOS -->
    <section id="premios">
        <div class="premios-hero" style="display:none;">
            <div class="premios-badge">
                <span class="premios-badge-icon">★</span>
                <span class="premios-badge-text">Proyecto Ganador Nacional</span>
            </div>
            <h2 class="premios-title">
                Mejoramiento y Sostenibilidad del Portal de la<br>
                <em>Ciencia y Cultura Ancashina</em>
            </h2>
            <p class="premios-subtitle">Proyecto ganador del Ministerio de Cultura con el cual pretendemos recopilar y difundir el Patrimonio Documental Ancashino en una plataforma virtual que permita el acceso universal a fuentes bibliográficas y documentales ancashinas.</p>
        </div>

        <div class="premios-video-wrap">
            <div class="premios-video">
                <img class="premios-video-bg"
                     src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=1200&q=80"
                     alt="Video portada">
                <div class="premios-video-overlay"></div>
                <div class="premios-video-play">
                    <div class="premios-play-btn">
                        <div class="premios-play-triangle"></div>
                    </div>
                </div>
                <div class="premios-video-info">
                    <div>
                        <p class="premios-video-name">Giber García Álamo</p>
                        <p class="premios-video-role">Director del Proyecto</p>
                    </div>
                    <span class="premios-video-yt">Mirar en YouTube</span>
                </div>
            </div>
        </div>

        <div class="premios-reconocimiento">
            <div class="premios-rec-card">
                <p class="premios-rec-label">Beneficiario de las Líneas de Apoyo Económico para el Sector Cultura</p>
                <div class="premios-ministerio">
                    <div class="premios-ministerio-peru">
                        <div class="premios-ministerio-escudo">
                            <div class="premios-ministerio-escudo-inner">PERÚ</div>
                        </div>
                        <span class="premios-ministerio-peru-text">PERÚ</span>
                    </div>
                    <div class="premios-ministerio-nombre">Ministerio de Cultura</div>
                </div>
                <div class="premios-director">
                    <img class="premios-director-avatar"
                         src="/giber.png"
                         alt="Giber García Álamo">
                    <div>
                        <p class="premios-director-label">Director del Proyecto</p>
                        <p class="premios-director-name">Giber García Álamo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </div><!-- /view-premios -->

    <!-- ===== VISTA: APORTANTES ===== -->
    <div id="view-aportantes" class="page-view" style="display:none;">

        {{-- Hero Banner (mismo patrón que Organización y Premios) --}}
        <section class="subview-hero">
            <div class="subview-hero-bg" style="background-image:url('{{ $heroBg }}');"></div>
            <div class="subview-hero-overlay"></div>
            <div class="subview-hero-content">
                <h1 class="subview-hero-title">Aportantes y Aliados</h1>
                <p class="subview-hero-sub">Un grupo de ciudadanos, empresas e instituciones que hacen posible la preservación de nuestro legado cultural.</p>
            </div>
        </section>

        {{-- Sección principal: categorías + director --}}
        <section style="padding:6rem 2rem;background:#f9f8f6;">
            <div style="max-width:1200px;margin:0 auto;">

                {{-- Encabezado de sección --}}
                <div class="section-header" style="margin-bottom:4rem;">
                    <p class="section-eyebrow">Red de Colaboración Cultural</p>
                    <h2 class="section-title">Nuestros Aportantes</h2>
                </div>

                <div style="display:grid;grid-template-columns:1fr 340px;gap:4rem;align-items:start;">

                    {{-- Columna izquierda: categorías --}}
                    <div style="display:flex;flex-direction:column;gap:3.5rem;">
                        @foreach($aportantes['categorias'] as $cat)
                        <div>
                            {{-- Título de categoría --}}
                            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.5rem;">
                                <div style="width:36px;height:36px;background:rgba(205,162,116,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @php
                                        $slugs = ['building','heart','landmark','star','users','book','globe','leaf','award','briefcase'];
                                        $isImg = $cat['icono'] && !in_array($cat['icono'], $slugs);
                                    @endphp
                                    @if($isImg)
                                        <img src="{{ $cat['icono'] }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                                    @elseif($cat['icono'] === 'building')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                    @elseif($cat['icono'] === 'heart')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                    @elseif($cat['icono'] === 'star')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    @elseif($cat['icono'] === 'users')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    @elseif($cat['icono'] === 'book')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                    @elseif($cat['icono'] === 'globe')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    @elseif($cat['icono'] === 'leaf')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 19.23A2 2 0 0 0 5.59 22c5.26-1.34 9.29-4.28 11.41-8.67C18 11 17.63 8.63 17 8z"/><path d="M3.82 19.23C3 20.23 2 21 2 21s0-6 5-10c1.35-1.08 3-1.67 5-2"/></svg>
                                    @elseif($cat['icono'] === 'award')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                                    @elseif($cat['icono'] === 'briefcase')
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                    @else
                                        <svg width="18" height="18" fill="none" stroke="#cda274" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="22" x2="21" y2="22"/><line x1="6" y1="18" x2="6" y2="11"/><line x1="10" y1="18" x2="10" y2="11"/><line x1="14" y1="18" x2="14" y2="11"/><line x1="18" y1="18" x2="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p style="font-size:.65rem;font-weight:700;color:#cda274;text-transform:uppercase;letter-spacing:.2em;margin-bottom:.2rem;">Categoría</p>
                                    <h3 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:#111;font-weight:700;">{{ $cat['titulo'] }}</h3>
                                </div>
                            </div>
                            <div style="height:1px;background:#e5e7eb;margin-bottom:1.5rem;"></div>

                            {{-- Items --}}
                            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                                @foreach($cat['items'] as $item)
                                <div class="about-box" style="display:flex;gap:1.5rem;align-items:flex-start;padding:1.75rem;cursor:default;">
                                    @if($item['foto'])
                                        <img src="{{ $item['foto'] }}" alt="{{ $item['nombre'] }}" loading="lazy"
                                             style="width:80px;height:80px;object-fit:cover;flex-shrink:0;border:1px solid #e5e7eb;">
                                    @else
                                        <div style="width:80px;height:80px;flex-shrink:0;border:1px solid #e5e7eb;background:#f9f8f6;display:flex;align-items:center;justify-content:center;">
                                            <svg width="32" height="32" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 style="font-family:'Playfair Display',serif;font-size:1.05rem;color:#111;margin-bottom:.5rem;">{{ $item['nombre'] }}</h4>
                                        <p class="about-text" style="margin:0;font-size:.875rem;">{{ $item['descripcion'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Columna derecha: Director --}}
                    <div style="position:sticky;top:7rem;">
                        <p style="font-size:.65rem;font-weight:700;color:#cda274;text-transform:uppercase;letter-spacing:.2em;margin-bottom:1.5rem;">Director</p>
                        <div style="background:white;border:1px solid #e5e7eb;padding:2rem;text-align:center;">
                            <div style="position:relative;width:140px;height:140px;margin:0 auto 1.5rem;">
                                <img src="{{ $aportantes['director']['foto'] }}" alt="{{ $aportantes['director']['nombre'] }}"
                                     style="width:140px;height:140px;object-fit:cover;border-radius:50%;border:3px solid #e5e7eb;"
                                     onerror="this.style.display='none'">
                                <div style="position:absolute;inset:-6px;border-radius:50%;border:1px solid #cda274;opacity:.4;pointer-events:none;"></div>
                            </div>
                            <p style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:#111;margin-bottom:.4rem;">{{ $aportantes['director']['nombre'] }}</p>
                            <p style="font-family:'Playfair Display',serif;font-style:italic;font-size:.95rem;color:#cda274;margin-bottom:1rem;">{{ $aportantes['director']['cargo'] }}</p>
                            <p class="about-text" style="font-size:.82rem;text-align:left;margin:0;">{{ $aportantes['director']['bio'] }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div><!-- /view-aportantes -->

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
                        <a href="#colecciones" class="footer-link" onclick="showView('inicio');setTimeout(()=>{document.getElementById('colecciones')?.scrollIntoView({behavior:'smooth'})},50);return false;">› Servicios</a>
                        <a href="#" class="footer-link" onclick="showView('organizacion');return false;">› Organización</a>
                        <a href="#" class="footer-link" onclick="showView('premios');return false;">› Premios</a>
                        <a href="{{ route('biblioteca.dashboard') }}" class="footer-link">› Biblioteca</a>
                        <a href="{{ route('fototeca.inicio') }}" class="footer-link">› Fototeca</a>
                    </div>
                </div>
                <!-- Contact -->
                <div>
                    <h4 class="footer-heading">Contacto</h4>
                    <div class="footer-contact-item">
                        <div class="">
                            <img src="/Direccion.png" alt="Dirección" style="width:30px;height:30px;object-fit:contain;">
                        </div>
                        <span>Esq. Av. Luzuriaga con Av. 28 de Julio<br>Huaraz, Áncash, Perú</span>
                    </div>
                    <div class="footer-contact-item">
                        <div class="">
                            <img src="/Telefono.png" alt="Teléfonos" style="width:30px;height:30px;object-fit:contain;">
                        </div>
                        <span>+51 952-845-942</span>
                    </div>
                    <div class="footer-contact-item">
                        <div class="">
                            <img src="/Email.png" alt="Correo Electrónico" style="width:30px;height:30px;object-fit:contain;">
                        </div>
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
                        <div class="modal-contact-icon-wrap">
                            <img src="/Direccion.png" alt="Dirección" style="width:50px;height:50px;object-fit:contain;">
                        </div>
                        <div>
                            <p class="modal-contact-label">Dirección</p>
                            <p class="modal-contact-value">Esq. Av. Luzuriaga con Av. 28 de Julio<br>Huaraz, Áncash, Perú</p>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                        <div class="modal-contact-card">
                            <div class="modal-contact-icon-wrap">
                                <img src="/Telefono.png" alt="Teléfonos" style="width:50px;height:50px;object-fit:contain;">
                            </div>
                            <div>
                                <p class="modal-contact-label">Teléfonos</p>
                                <p class="modal-contact-value">952 845 942</p>
                            </div>
                        </div>
                        <div class="modal-contact-card">
                            <div class="modal-contact-icon-wrap">
                                <img src="/Email.png" alt="Email" style="width:50px;height:50px;object-fit:contain;">
                            </div>
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
        // Navbar — oscurecer al hacer scroll
        const _header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                _header.classList.add('scrolled');
            } else {
                _header.classList.remove('scrolled');
            }
        }, { passive: true });

        // Mobile menu
        function openMobileMenu()  { document.getElementById('mobileMenu').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeMobileMenu() { document.getElementById('mobileMenu').classList.remove('open'); document.body.style.overflow = ''; }

        // ── VISTAS (Inicio / Organización / Premios) ──
        function showView(name) {
            ['inicio','organizacion','premios','aportantes'].forEach(v => {
                const el = document.getElementById('view-' + v);
                if (el) el.style.display = (v === name) ? '' : 'none';
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (name === 'inicio') {
                const carousel = document.getElementById('collectionsCarousel');
                if (carousel && window._carouselInit) window._carouselInit();
            }
        }
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

        // ========== CAROUSEL SLIDER - BUCLE INFINITO ==========
        (function() {
            const carousel     = document.getElementById('collectionsCarousel');
            const carouselWrap = carousel.closest('.collections-carousel-container');
            const origCards    = Array.from(carousel.querySelectorAll('.collection-card'));
            const n            = origCards.length;
            const ANIM_MS      = 700;
            const AUTO_DELAY   = 4000;

            let CARD_W = window.innerWidth < 768 ? 300 : 420;
            let GAP    = window.innerWidth < 768 ? 16  : 32;
            let SHIFT  = CARD_W + GAP;

            // Triplicar para bucle infinito
            carousel.innerHTML = '';
            [...origCards, ...origCards, ...origCards].forEach(c => carousel.appendChild(c.cloneNode(true)));
            carousel.style.gap = GAP + 'px';

            let current  = n;
            let busy     = false;
            let autoTimer;

            const allCards = () => carousel.querySelectorAll('.collection-card');

            // Calcula el offset usando el ancho real del contenedor (no 50vw)
            function getOffset() {
                const containerW = carouselWrap.getBoundingClientRect().width;
                return (containerW / 2) - (CARD_W / 2);
            }

            function applyTransform(animated) {
                carousel.style.transition = animated ? `transform ${ANIM_MS}ms ease-in-out` : 'none';
                carousel.style.transform  = `translateX(${getOffset() - current * SHIFT}px)`;
            }

            // Recalcular en resize
            window.addEventListener('resize', () => {
                CARD_W = window.innerWidth < 768 ? 300 : 420;
                GAP    = window.innerWidth < 768 ? 16  : 32;
                SHIFT  = CARD_W + GAP;
                carousel.style.gap = GAP + 'px';
                applyTransform(false);
            }, { passive: true });

            function updateStates() {
                allCards().forEach((card, i) => {
                    card.classList.toggle('active',   i === current);
                    card.classList.toggle('inactive', i !== current);
                });
            }

            function updateDots() {
                document.querySelectorAll('.carousel-dot').forEach((dot, i) => {
                    dot.classList.toggle('active', i === (current % n));
                });
            }

            function teleportIfNeeded() {
                // Al llegar al tercer bloque, salta silenciosamente al segundo (central)
                if (current >= n * 2) {
                    current = current - n;
                    applyTransform(false);
                } else if (current < n) {
                    current = current + n;
                    applyTransform(false);
                }
            }

            function go(newCurrent) {
                if (busy) return;
                busy = true;
                current = newCurrent;
                applyTransform(true);
                updateStates();
                updateDots();
                setTimeout(() => {
                    teleportIfNeeded();
                    updateStates();
                    updateDots();
                    busy = false;
                }, ANIM_MS + 20);
            }

            function initDots() {
                const container = document.getElementById('carouselDots');
                container.innerHTML = '';
                for (let i = 0; i < n; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
                    dot.addEventListener('click', () => {
                        if (busy) return;
                        clearInterval(autoTimer);
                        go(n + i);
                        startAuto();
                    });
                    container.appendChild(dot);
                }
            }

            function startAuto() {
                clearInterval(autoTimer);
                autoTimer = setInterval(() => {
                    if (busy) return;
                    go(current + 1);
                }, AUTO_DELAY);
            }

            window.scrollCarousel = function(dir) {
                if (busy) return;
                clearInterval(autoTimer);
                go(current + (dir === 'next' ? 1 : -1));
                startAuto();
            };

            // Click en tarjeta activa → navegar; click en inactiva → centrar
            carousel.addEventListener('click', function(e) {
                const card = e.target.closest('.collection-card');
                if (!card) return;
                const idx = Array.from(allCards()).indexOf(card);
                if (idx === current) {
                    const url = card.dataset.url;
                    if (url) window.location.href = url;
                } else {
                    if (busy) return;
                    clearInterval(autoTimer);
                    go(idx);
                    startAuto();
                }
            });

            initDots();
            applyTransform(false);
            updateStates();
            updateDots();
            startAuto();
        })();
    </script>
    <x-floating-buttons />
</body>
</html>
