{{-- PIXEL-EXACT port from signed-off https://fansfollowme.com (creators)
     Do NOT restyle. Auth forms/routes only. --}}
<!doctype html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Browse and discover verified creators on FansFollow.me &#8212; filter by category and gender to find your favorite fitness, combat sports, and entertainment talent.">
  <link rel="canonical" href="https://fansfollowme.com/creators.html">
  <meta name="theme-color" content="#f97316">
  <title>Creators - FansFollow.me</title>
  <link href="data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 64 64%27%3E%3Crect width=%2764%27 height=%2764%27 rx=%2712%27 fill=%27%230d1119%27/%3E%3Ctext x=%2732%27 y=%2744%27 font-size=%2736%27 font-weight=%27bold%27 text-anchor=%27middle%27 fill=%27%23f97316%27 font-family=%27Arial,sans-serif%27%3EF%3C/text%3E%3C/svg%3E" rel="icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/ffm-mobile-spacing.css') }}?v=ffm1" rel="stylesheet">
  <style>
  :root {
    color-scheme: dark;
    --ffm-text: #e5e7eb;
    --ffm-muted: #94a3b8;
    --ffm-line: rgba(148, 163, 184, 0.14);
    --bg: #0b0f1a;
    --panel: #151b2c;
    --shadow: 0 18px 54px rgba(0, 0, 0, 0.36);
    --cta-gradient: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%);
    --cta-gradient-2: linear-gradient(135deg, #f97316 0%, #9333ea 100%);
  }
  * { box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body {
    margin: 0;
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-weight: 400;
    color: var(--ffm-text);
    background-color: #020617;
    overflow-x: clip;
  }
  a { color: inherit; text-decoration: none; }
  img { max-width: 100%; display: block; }

  .public-shell-topbar {
    position: sticky; top: 0; z-index: 40;
    background: transparent; border-bottom: 1px solid transparent; box-shadow: none;
    transition: background .3s, border-color .3s, box-shadow .3s;
  }
  .public-shell-topbar.scrolled {
    background: rgba(11,15,26,0.82); backdrop-filter: blur(18px);
    border-bottom: 1px solid rgba(255,255,255,.06); box-shadow: 0 4px 16px rgba(0,0,0,.15);
  }
  .public-shell-topbar .inner { min-height: 72px; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
  .public-shell-brand img { height: 30px; width: auto; }
  .public-shell-nav { display: flex; align-items: center; flex-wrap: wrap; gap: 0.15rem; }
  .public-shell-nav a, .public-shell-nav summary {
    padding: 0.5rem 0.7rem; border-radius: 10px; font-weight: 700; font-size: 0.9rem;
    color: #cbd5e1; cursor: pointer; list-style: none;
    transition: background-color .16s ease, color .16s ease, transform .16s ease;
  }
  .public-shell-nav a:hover, .public-shell-nav a.active, .public-shell-nav summary:hover, .public-shell-nav details[open] > summary {
    color: #fb923c; background: none; transform: translateY(-1px);
  }
  .public-shell-nav details { position: relative; }
  .public-shell-nav details > summary::-webkit-details-marker { display: none; }
  .public-shell-nav summary::after { content: '\25BE'; display: inline-block; margin-left: .35rem; font-size: .82em; line-height: 1; opacity: .8; transform: translateY(-1px); }
  .public-shell-nav details[open] > summary::after { transform: translateY(-1px) rotate(180deg); }
  .public-shell-nav-panel {
    position: absolute; top: calc(100% + .55rem); left: 0; min-width: 220px; padding: .45rem;
    background: #151b2c; border: 1px solid rgba(255,255,255,.08); border-radius: 16px;
    box-shadow: var(--shadow); display: grid; gap: .15rem; z-index: 5;
  }
  .public-shell-nav-panel a { padding: .7rem .8rem; border-radius: 12px; font-weight: 600; color: #e5e7eb; display: flex; align-items: center; gap: .6rem; }
  .public-shell-nav-panel a:hover { background: rgba(255,255,255,.08); color: #fff; }
  .public-shell-actions { display: flex; gap: .6rem; align-items: center; }
  .public-shell-button { border-radius: 12px; font-weight: 700; min-height: 44px; padding: 0.65rem 1.1rem; border-width: 1px; font-size: .9rem; }
  .public-shell-button.btn-primary { background: var(--cta-gradient); color: #fff; border-color: transparent; box-shadow: 0 10px 20px rgba(249, 115, 22, .3); }
  .public-shell-button.btn-primary:hover { filter: brightness(1.1); color: #fff; }
  .public-shell-button.btn-outline-primary { color: #e5e7eb; border: none; background: rgba(30,41,59,.9); }
  .public-shell-button.btn-outline-primary:hover { background: rgba(51,65,85,.9); color: #fff; }
  .container { max-width: 1280px !important; padding-left: 1rem; padding-right: 1rem; width: 100%; }
  @@media (min-width: 640px) { .container { padding-left: 1.5rem; padding-right: 1.5rem; } }
  @@media (min-width: 1024px) { .container { padding-left: 2rem; padding-right: 2rem; } }

  .public-shell-hamburger { display: none; background: none; border: none; color: #e5e7eb; padding: .5rem; cursor: pointer; min-width: 44px; min-height: 44px; align-items: center; justify-content: center; }
  @@media (max-width: 991.98px) { .public-shell-hamburger { display: flex; } .public-shell-actions { display: none; } }

  .mobile-menu-overlay { display: none; position: fixed; inset: 0; z-index: 100; background: rgba(0,0,0,.6); backdrop-filter: blur(4px); }
  .mobile-menu-overlay.is-open { display: block; }
  .mobile-menu-panel {
    position: fixed; top: 0; right: 0; bottom: 0; width: min(85vw, 360px); z-index: 101;
    background: linear-gradient(180deg, #151b2c 0%, #0f172a 100%); border-left: 1px solid rgba(255,255,255,.08);
    transform: translateX(100%); transition: transform .3s ease; overflow-y: auto; display: flex; flex-direction: column; padding: 1.5rem;
  }
  .mobile-menu-panel.is-open { transform: translateX(0); }
  .mobile-menu-close { display: flex; justify-content: flex-end; margin-bottom: 1rem; }
  .mobile-menu-close button { background: none; border: none; color: #e5e7eb; padding: .5rem; cursor: pointer; min-width: 44px; min-height: 44px; display: flex; align-items: center; justify-content: center; }
  .mobile-menu-section-label { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; padding: .6rem 0; }
  .mobile-menu-panel a { display: flex; align-items: center; min-height: 44px; padding: .75rem 0; color: #e5e7eb; font-size: 1.05rem; font-weight: 600; transition: color .2s; }
  .mobile-menu-panel a:hover { color: #fb923c; }
  .mobile-menu-panel .mobile-cta-btn { display: block; width: 100%; padding: 1rem; margin-top: 1rem; border-radius: 12px; font-weight: 800; font-size: 1rem; text-align: center; color: #fff; background: var(--cta-gradient); min-height: 56px; box-shadow: 0 14px 28px rgba(249, 115, 22, .24); }

  .public-shell-footer { padding: 1.5rem 0 1.2rem; color: #94a3b8; background: linear-gradient(135deg, #111827, #1f2937, #111827); border-top: 1px solid #1f293b; }
  .public-shell-footer .footer-topline, .public-shell-footer .footer-bottomline { height: 3px; width: 100%; border-radius: 999px; background: linear-gradient(90deg, rgba(249,115,22,0) 0%, rgba(249,115,22,.85) 18%, rgba(168,85,247,.95) 50%, rgba(236,72,153,.85) 82%, rgba(236,72,153,0) 100%); opacity: .95; }
  .public-shell-footer .footer-topline { margin-bottom: 1rem; }
  .public-shell-footer .footer-bottomline { margin-top: 1.5rem; margin-bottom: .75rem; }
  .public-shell-footer .footer-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1.5rem; align-items: start; }
  .public-shell-footer h3 { margin: 0 0 .75rem; font-size: .875rem; font-weight: 700; color: #fff; position: relative; padding-bottom: .75rem; }
  .public-shell-footer h3::after { content: ''; position: absolute; left: 0; bottom: 0; width: 32px; height: 2px; border-radius: 999px; background: var(--cta-gradient); }
  .public-shell-footer .footer-links a { display: block; padding: .35rem 0; color: #9ca3af; font-size: .75rem; line-height: 1.4; }
  .public-shell-footer .footer-links a:hover { color: #fff; }
  .public-shell-footer .footer-social a { width: 44px; height: 44px; border-radius: 999px; display: inline-flex; align-items: center; justify-content: center; background: #1f2937; color: #9ca3af; border: 1px solid rgba(255,255,255,.08); }
  .public-shell-footer .footer-social a:hover { background: rgba(249,115,22,.16); border-color: rgba(249,115,22,.24); color: #fff; }
  @@media (max-width: 991.98px) {
    .public-shell-footer .footer-grid { grid-template-columns: 1fr 1fr; gap: 1.1rem; }
    .public-shell-footer .footer-bottom { align-items: center; text-align: center; }
  }

  /* â”€â”€ Creators page styles â”€â”€ */
  .creators-shell { padding: 2rem 0 3rem; }
  .page-h1 { font-size: 1.75rem; font-weight: 800; color: #fff; margin: 0 0 .5rem; }
  .page-sub { color: var(--ffm-muted); font-size: .9rem; margin: 0 0 1.5rem; }

  .creators-search { position: relative; margin-bottom: 1.5rem; max-width: 480px; }
  .creators-search svg { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #64748b; width: .9rem; height: .9rem; pointer-events: none; }
  .creators-search .form-control { width: 100%; background: rgba(51,65,85,.6); border: 1px solid rgba(148,163,184,.18); color: #e2e8f0; border-radius: 12px; padding: .75rem 1rem .75rem 2.75rem; font-size: .95rem; }
  .creators-search .form-control::placeholder { color: #9ca3af; }
  .creators-search .form-control:focus { border-color: #f97316; box-shadow: 0 0 0 .2rem rgba(249,115,22,.15); outline: none; }

  .filter-section { margin-bottom: 1.5rem; }
  .filter-label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #9ca3af; margin-bottom: .5rem; }
  .filter-pills { display: flex; flex-wrap: wrap; gap: .5rem; }
  .filter-pill { padding: .375rem .75rem; border-radius: 999px; font-size: .75rem; font-weight: 600; border: none; cursor: pointer; transition: all .2s; min-height: 44px; display: inline-flex; align-items: center; }
  .filter-pill--inactive { background: rgba(51,65,85,.6); color: #cbd5e1; }
  .filter-pill--inactive:hover { background: rgba(71,85,105,.8); color: #fff; }
  .filter-pill--active { background: linear-gradient(135deg, #f97316, #9333ea); color: #fff; }

  .creators-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem; }
  .creator-card { background: rgba(15,23,42,.6); border: 1px solid rgba(255,255,255,.06); border-radius: 16px; overflow: hidden; transition: all .3s ease; display: flex; flex-direction: column; }
  .creator-card:hover { border-color: rgba(249,115,22,.3); transform: translateY(-3px); box-shadow: 0 12px 36px rgba(0,0,0,.25); }
  .creator-card-cover { height: 80px; background: linear-gradient(135deg, #1e3a8a, #6366f1, #a855f7); }
  .creator-card-body { padding: 0 1.25rem 1.25rem; text-align: center; margin-top: -40px; }
  .creator-card-avatar { width: 72px; height: 72px; border-radius: 50%; border: 4px solid var(--panel); margin: 0 auto .75rem; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.4rem; color: #fff; background: linear-gradient(135deg, #f97316, #9333ea); }
  .creator-card-name { font-weight: 700; color: #fff; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: .3rem; }
  .creator-card-handle { color: #94a3b8; font-size: .82rem; margin-bottom: .5rem; }
  .creator-card-bio { color: #d1d5db; font-size: .82rem; line-height: 1.5; margin-bottom: .75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .creator-card-stats { display: flex; justify-content: center; gap: 1.25rem; color: #94a3b8; font-size: .78rem; margin-bottom: 1rem; }
  .creator-card-stats span { display: flex; align-items: center; gap: .25rem; }
  .creator-card-btn { width: 100%; padding: .6rem; border-radius: 10px; font-weight: 700; font-size: .85rem; border: none; cursor: pointer; transition: filter .18s; min-height: 44px; }
  .creator-card-btn--primary { background: var(--cta-gradient-2); color: #fff; }
  .creator-card-btn--primary:hover { filter: brightness(1.1); }
  .creator-card-btn--outline { background: transparent; border: 1px solid rgba(255,255,255,.15); color: #cbd5e1; }
  .creator-card-btn--outline:hover { background: rgba(255,255,255,.06); color: #fff; }

  .verified-badge { display: inline-flex; align-items: center; justify-content: center; width: 18px; height: 18px; border-radius: 50%; background: #3b82f6; color: #fff; font-size: .65rem; }
  </style>
<meta property="og:title" content="Creators - FansFollow.me">
<meta property="og:description" content="Browse and discover verified creators on FansFollow.me &#8212; filter by category and gender to find your favorite fitness, combat sports, and entertainment talent.">
<meta property="og:image" content="/public/logo-full-lockup.png">
<meta property="og:url" content="https://fansfollowme.com/creators.html">
<meta property="og:type" content="website"></head>
<body>
  <header class="public-shell-topbar">
    <div class="container inner">
      <a aria-label='FansFollow.me' class='public-shell-brand' href='{{ route('home') }}'>
        <img src="/public/logo-monogram.png" alt="FansFollow.me" height="40">
      </a>
      <nav class="public-shell-nav d-none d-lg-flex" aria-label="Primary">
        <a href='{{ route('page.for-creators') }}'>For Creators</a>
        <a href='{{ route('page.fans') }}'>For Fans</a>
        <a href='{{ route('page.celebrities') }}'>Celebrities</a>
        <a href='{{ route('page.explore') }}'>Explore</a>
        <a class='active' href='{{ route('page.creators') }}'>Creators</a>
        <details class="public-shell-more">
          <summary>More</summary>
          <div class="public-shell-nav-panel">
            <a href='{{ route('page.casting') }}'>&#127912; <span>Movie Casting</span></a>
            <a href='{{ route('page.live-streams') }}'>&#128308; <span>Live Streams</span></a>
            <a href='{{ route('page.business') }}'>&#128188; <span>Business</span></a>
            <a href='{{ route('page.support') }}'>&#128172; <span>Support</span></a>
          </div>
        </details>
      </nav>
      <div class="public-shell-actions">
                                @guest
                                <a class="btn btn-primary public-shell-button" style="background: var(--cta-gradient); background-image: var(--cta-gradient); border-color: transparent; box-shadow: 0 14px 28px rgba(249, 115, 22, .24);" href="{{ route('register') }}">Get Started</a>
                    <a class="btn btn-outline-primary public-shell-button" href="{{ route('login') }}">Login</a>
                                @else
                                @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
                                <a class="btn btn-outline-primary public-shell-button" href="{{ route('creator.dashboard') }}">Studio</a>
                                @endif
                                @if (auth()->user()->isAdmin())
                                <a class="btn btn-outline-primary public-shell-button" href="{{ route('admin.dashboard') }}">Admin</a>
                                @endif
                                <a class="btn btn-primary public-shell-button" style="background: var(--cta-gradient); background-image: var(--cta-gradient); border-color: transparent; box-shadow: 0 14px 28px rgba(249, 115, 22, .24);" href="{{ route('dashboard') }}">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="m-0 d-inline">@csrf<button type="submit" class="btn btn-outline-primary public-shell-button">Logout</button></form>
                                @endguest
              </div>
              <button class="public-shell-hamburger" onclick="document.querySelector('.mobile-menu-overlay').classList.add('is-open');document.querySelector('.mobile-menu-panel').classList.add('is-open')" aria-label="Open menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
      </button>
    </div>
  </header>

  <div class="mobile-menu-overlay" onclick="this.classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')"></div>
  <div class="mobile-menu-panel">
    <div class="mobile-menu-close">
      <button onclick="document.querySelector('.mobile-menu-overlay').classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')" aria-label="Close menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
      </button>
    </div>
    <div class="mobile-menu-section-label">Navigation</div>
    <a href='{{ route('page.for-creators') }}'>For Creators</a>
    <a href='{{ route('page.fans') }}'>For Fans</a>
    <a href='{{ route('page.celebrities') }}'>Celebrities</a>
    <a href='{{ route('page.explore') }}'>Explore</a>
    <a href='{{ route('page.creators') }}'>Creators</a>
    <div class="mobile-menu-section-label" style="margin-top:.5rem">More</div>
    <a href='{{ route('page.casting') }}'>&#127912; Movie Casting</a>
    <a href='{{ route('page.live-streams') }}'>&#128308; Live Streams</a>
    <a href='{{ route('page.business') }}'>&#128188; Business</a>
    <a href='{{ route('page.support') }}'>&#128172; Support</a>
    <a href='{{ route('login') }}' style='margin-top:1rem;color:#94a3b8;font-weight:600'>Login</a>
    <a class='mobile-cta-btn' href='{{ route('register') }}'>Get Started</a>
  </div>

  <main class="public-shell-content">
    <section class="creators-shell">
      <div class="container">
        <h1 class="page-h1">Creators</h1>
        <p class="page-sub">Discover and connect with verified creators on FansFollow.me</p>

        <div class="creators-search">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" class="form-control" placeholder="Search creators by name or handle...">
        </div>

        <div class="filter-section">
          <div class="filter-label">Category</div>
          <div class="filter-pills">
            <span class="filter-pill filter-pill--active" onclick="document.querySelectorAll('.filter-pill[data-cat]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">All</span>
            <span class="filter-pill filter-pill--inactive" data-cat="fitness" onclick="document.querySelectorAll('.filter-pill[data-cat]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">Fitness / Gym</span>
            <span class="filter-pill filter-pill--inactive" data-cat="bodybuilding" onclick="document.querySelectorAll('.filter-pill[data-cat]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">Bodybuilding</span>
            <span class="filter-pill filter-pill--inactive" data-cat="combat" onclick="document.querySelectorAll('.filter-pill[data-cat]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">Combat Sports</span>
            <span class="filter-pill filter-pill--inactive" data-cat="martial" onclick="document.querySelectorAll('.filter-pill[data-cat]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">Martial Arts</span>
            <span class="filter-pill filter-pill--inactive" data-cat="nutrition" onclick="document.querySelectorAll('.filter-pill[data-cat]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">Nutrition</span>
            <span class="filter-pill filter-pill--inactive" data-cat="actor" onclick="document.querySelectorAll('.filter-pill[data-cat]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">Actor / Actress</span>
          </div>
        </div>

        <div class="filter-section">
          <div class="filter-label">Gender</div>
          <div class="filter-pills">
            <span class="filter-pill filter-pill--active" onclick="document.querySelectorAll('.filter-pill[data-gender]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">All</span>
            <span class="filter-pill filter-pill--inactive" data-gender="male" onclick="document.querySelectorAll('.filter-pill[data-gender]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">Male</span>
            <span class="filter-pill filter-pill--inactive" data-gender="female" onclick="document.querySelectorAll('.filter-pill[data-gender]').forEach(p=>p.classList.replace('filter-pill--active','filter-pill--inactive'));this.classList.replace('filter-pill--inactive','filter-pill--active')">Female</span>
          </div>
        </div>

        <div class="creators-grid">
          <!-- Creator 1 -->
          <div class="creator-card">
            <div class="creator-card-cover"></div>
            <div class="creator-card-body">
              <div class="creator-card-avatar">JJ</div>
              <div class="creator-card-name">Justice Jimmy Millar <span class="verified-badge" title="Verified"><i class="fas fa-check"></i></span></div>
              <div class="creator-card-handle">@JusticeJimmy</div>
              <div class="creator-card-bio">Pro fighter and ambassador. Sharing exclusive training footage, fight prep, and behind-the-scenes content.</div>
              <div class="creator-card-stats">
                <span><i class="fas fa-users"></i> 12.4K</span>
                <span><i class="fas fa-image"></i> 48</span>
                <span><i class="fas fa-video"></i> 22</span>
              </div>
              <a class='creator-card-btn creator-card-btn--primary' href='/creator-profile-populated'>View Profile</a>
            </div>
          </div>

          <!-- Creator 2 -->
          <div class="creator-card">
            <div class="creator-card-cover" style="background: linear-gradient(135deg, #dc2626, #f97316, #fbbf24);"></div>
            <div class="creator-card-body">
              <div class="creator-card-avatar">FM</div>
              <div class="creator-card-name">FFM-Martin <span class="verified-badge" title="Verified"><i class="fas fa-check"></i></span></div>
              <div class="creator-card-handle">@FFM-Martin</div>
              <div class="creator-card-bio">Golf enthusiast and content creator. Sharing tips, challenges, and course vlogs for all skill levels.</div>
              <div class="creator-card-stats">
                <span><i class="fas fa-users"></i> 8.1K</span>
                <span><i class="fas fa-image"></i> 35</span>
                <span><i class="fas fa-video"></i> 18</span>
              </div>
              <a class='creator-card-btn creator-card-btn--primary' href='/creator-profile-populated'>View Profile</a>
            </div>
          </div>

          <!-- Creator 3 -->
          <div class="creator-card">
            <div class="creator-card-cover" style="background: linear-gradient(135deg, #059669, #10b981, #34d399);"></div>
            <div class="creator-card-body">
              <div class="creator-card-avatar">DK</div>
              <div class="creator-card-name">David Kurzhal <span class="verified-badge" title="Verified"><i class="fas fa-check"></i></span></div>
              <div class="creator-card-handle">@VikingSamurai</div>
              <div class="creator-card-bio">Founder of FansFollow.me. Martial artist, bodybuilder, and entrepreneur building the creator economy.</div>
              <div class="creator-card-stats">
                <span><i class="fas fa-users"></i> 5.6K</span>
                <span><i class="fas fa-image"></i> 20</span>
                <span><i class="fas fa-video"></i> 10</span>
              </div>
              <a class='creator-card-btn creator-card-btn--primary' href='{{ route('register') }}'>View Profile</a>
            </div>
          </div>

          <!-- Creator 4 -->
          <div class="creator-card">
            <div class="creator-card-cover" style="background: linear-gradient(135deg, #7c3aed, #a855f7, #ec4899);"></div>
            <div class="creator-card-body">
              <div class="creator-card-avatar">SL</div>
              <div class="creator-card-name">Sara Lopez</div>
              <div class="creator-card-handle">@SaraLopezFit</div>
              <div class="creator-card-bio">Certified nutritionist and fitness coach. Meal plans, workout routines, and one-on-one coaching sessions.</div>
              <div class="creator-card-stats">
                <span><i class="fas fa-users"></i> 3.2K</span>
                <span><i class="fas fa-image"></i> 15</span>
                <span><i class="fas fa-video"></i> 8</span>
              </div>
              <a class='creator-card-btn creator-card-btn--primary' href='{{ route('register') }}'>View Profile</a>
            </div>
          </div>

          <!-- Creator 5 -->
          <div class="creator-card">
            <div class="creator-card-cover" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6, #6366f1);"></div>
            <div class="creator-card-body">
              <div class="creator-card-avatar">MT</div>
              <div class="creator-card-name">Mike Torres <span class="verified-badge" title="Verified"><i class="fas fa-check"></i></span></div>
              <div class="creator-card-handle">@MikeTorresMMA</div>
              <div class="creator-card-bio">MMA fighter and coach. Sparring footage, technique breakdowns, and fight night vlogs.</div>
              <div class="creator-card-stats">
                <span><i class="fas fa-users"></i> 7.8K</span>
                <span><i class="fas fa-image"></i> 30</span>
                <span><i class="fas fa-video"></i> 15</span>
              </div>
              <a class='creator-card-btn creator-card-btn--primary' href='{{ route('register') }}'>View Profile</a>
            </div>
          </div>

          <!-- Creator 6 -->
          <div class="creator-card">
            <div class="creator-card-cover" style="background: linear-gradient(135deg, #f59e0b, #ef4444, #ec4899);"></div>
            <div class="creator-card-body">
              <div class="creator-card-avatar">AC</div>
              <div class="creator-card-name">Amy Chen</div>
              <div class="creator-card-handle">@AmyChenYoga</div>
              <div class="creator-card-bio">Yoga instructor and wellness coach. Guided sessions, meditation guides, and flexibility programs.</div>
              <div class="creator-card-stats">
                <span><i class="fas fa-users"></i> 2.1K</span>
                <span><i class="fas fa-image"></i> 12</span>
                <span><i class="fas fa-video"></i> 6</span>
              </div>
              <a class='creator-card-btn creator-card-btn--primary' href='{{ route('register') }}'>View Profile</a>
            </div>
          </div>

          <!-- Creator 7 -->
          <div class="creator-card">
            <div class="creator-card-cover" style="background: linear-gradient(135deg, #1e40af, #3b82f6, #60a5fa);"></div>
            <div class="creator-card-body">
              <div class="creator-card-avatar">RP</div>
              <div class="creator-card-name">Ryan Park <span class="verified-badge" title="Verified"><i class="fas fa-check"></i></span></div>
              <div class="creator-card-handle">@RyanParkBoxing</div>
              <div class="creator-card-bio">Pro boxer sharing training camps, pad work drills, and exclusive fight footage you won't find anywhere else.</div>
              <div class="creator-card-stats">
                <span><i class="fas fa-users"></i> 9.3K</span>
                <span><i class="fas fa-image"></i> 40</span>
                <span><i class="fas fa-video"></i> 19</span>
              </div>
              <a class='creator-card-btn creator-card-btn--primary' href='{{ route('register') }}'>View Profile</a>
            </div>
          </div>

          <!-- Creator 8 -->
          <div class="creator-card">
            <div class="creator-card-cover" style="background: linear-gradient(135deg, #be185d, #ec4899, #f472b6);"></div>
            <div class="creator-card-body">
              <div class="creator-card-avatar">JW</div>
              <div class="creator-card-name">Jasmine Wright</div>
              <div class="creator-card-handle">@JasmineW</div>
              <div class="creator-card-bio">Actress and model. Behind-the-scenes from film sets, personal video messages, and exclusive photoshoots.</div>
              <div class="creator-card-stats">
                <span><i class="fas fa-users"></i> 4.5K</span>
                <span><i class="fas fa-image"></i> 25</span>
                <span><i class="fas fa-video"></i> 12</span>
              </div>
              <a class='creator-card-btn creator-card-btn--primary' href='{{ route('register') }}'>View Profile</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="public-shell-footer">
    <div class="container">
      <div class="footer-topline"></div>
      <div class="footer-grid" style="gap: 2rem;">
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">For Creators</h3>
          <a href='{{ route('register') }}' style='font-size: .9rem;'>Getting Started</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Personal Video Messages</a>
        </div>
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Revenue Streams</h3>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Content Monetization</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Paid Phone Calls</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Text Coaching</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Video Consultations</a>
        </div>
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Support</h3>
          <a href='{{ route('page.support') }}' style='font-size: .9rem;'>Help Center</a>
          <a href='{{ route('page.contact') }}' style='font-size: .9rem;'>Contact Us</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Creator Resources</a>
          <a href='{{ route('page.contact') }}' style='font-size: .9rem;'>Community</a>
        </div>
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Coming Soon</h3>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Creator Competitions</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Gym Monster</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Mini Leagues</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Mobile App</span>
          <!-- TOKEN-LINK-RESTORE: <a href='/business#token' style='font-size: .9rem;'>Token Ecosystem</a> -->
          <!-- PRESALE-LINK-RESTORE: <a href='/business#presale' style='font-size: .9rem;'>Presale Info</a> -->
        </div>
      </div>
      <div class="footer-bottomline"></div>
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: .75rem; padding: .75rem 0;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
          <span style="font-size: .85rem; color: #94a3b8;">© 2026 FansFollow.me. All rights reserved.</span>
          <span style="font-size: .85rem; color: #94a3b8;"><span style="color: #f97316; font-weight: 800;">&#8383;</span> <strong style="color: #fff;">BTC/ETH/USDT/SOL Accepted</strong></span>
          <a href='{{ route('page.privacy') }}' style='font-size: .85rem; color: #94a3b8;'>Privacy Policy</a>
          <span style="color: #4b5563;">&bull;</span>
          <a href='{{ route('page.terms') }}' style='font-size: .85rem; color: #94a3b8;'>Terms of Service</a>
          <span style="color: #4b5563;">&bull;</span>
          <a href='{{ route('page.cookies') }}' style='font-size: .85rem; color: #94a3b8;'>Cookie Policy</a>
          <span style="color: #4b5563;">&bull;</span>
          <a href='{{ route('page.faq') }}' style='font-size: .85rem; color: #94a3b8;'>FAQ</a>
        </div>
        <div style="display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;">
          <span style="font-size: .85rem; color: #94a3b8;">Follow us:</span>
          <div class="footer-social" style="display: flex; gap: .5rem;" aria-label="Social links">
            <a href="https://www.facebook.com/profile.php?id=100089966703593" target="_blank" rel="noopener" aria-label="Facebook" style="color: #94a3b8;"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/fansfollowdotme" target="_blank" rel="noopener" aria-label="Instagram" style="color: #94a3b8;"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/@FFMFansFollowME" target="_blank" rel="noopener" aria-label="YouTube" style="color: #94a3b8;"><i class="fab fa-youtube"></i></a>
            <a href="https://www.tiktok.com/@fansfollow.me" target="_blank" rel="noopener" aria-label="TikTok" style="color: #94a3b8;"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function() {
      var bar = document.querySelector('.public-shell-topbar');
      if (!bar) return;
      function onScroll() {
        if (window.scrollY > 20) { bar.classList.add('scrolled'); }
        else { bar.classList.remove('scrolled'); }
      }
      window.addEventListener('scroll', onScroll, {passive: true});
      onScroll();
    })();
  </script>
</body>
</html>
