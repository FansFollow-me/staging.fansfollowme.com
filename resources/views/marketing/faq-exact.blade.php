{{-- PIXEL-EXACT port from signed-off https://fansfollowme.com (faq)
     Do NOT restyle. Auth forms/routes only. --}}
<!doctype html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Frequently asked questions about FansFollow &#8212; creator earnings, payments, and platform features.">
  <link rel="canonical" href="https://fansfollowme.com/faq.html">
  <meta name="theme-color" content="#f97316">
  <title>FAQ - FansFollow.me</title>
  <link href="data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 64 64%27%3E%3Crect width=%2764%27 height=%2764%27 rx=%2712%27 fill=%27%230d1119%27/%3E%3Ctext x=%2732%27 y=%2744%27 font-size=%2736%27 font-weight=%27bold%27 text-anchor=%27middle%27 fill=%27%23f97316%27 font-family=%27Arial,sans-serif%27%3EF%3C/text%3E%3C/svg%3E" rel="icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/ffm-mobile-spacing.css') }}?v=ffm5" rel="stylesheet">
  <style>
  :root {
    color-scheme: dark;
    --ffm-text: #e5e7eb;
    --ffm-muted: #94a3b8;
    --ffm-line: rgba(148, 163, 184, 0.14);
    --ffm-accent: #60a5fa;
    --bg: #0b0f1a;
    --panel: #151b2c;
    --shadow: 0 18px 54px rgba(0, 0, 0, 0.36);
    --cta-gradient: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%);
  }
  * { box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body { margin: 0; font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-weight: 400; color: var(--ffm-text); background-color: #020617; overflow-x: clip; }
  a { color: inherit; text-decoration: none; }
  img { max-width: 100%; display: block; }
  h1, h2, h3, h4, h5, h6 { font-family: 'Inter', sans-serif; color: var(--ffm-text); }

  .public-shell-topbar { position: sticky; top: 0; z-index: 40; background: transparent; border-bottom: 0; box-shadow: none; transition: background .3s, border-color .3s, box-shadow .3s; }
  .public-shell-topbar.scrolled { background: rgba(11,15,26,0.82); backdrop-filter: blur(18px); border-bottom: 1px solid rgba(255,255,255,.06); box-shadow: 0 4px 16px rgba(0,0,0,.15); }
  .public-shell-topbar .inner { min-height: 72px; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
  .public-shell-brand img { height: 30px; width: auto; }
  .public-shell-nav { display: flex; align-items: center; flex-wrap: wrap; gap: 0.15rem; }
  .public-shell-nav a, .public-shell-nav summary { padding: 0.5rem 0.7rem; border-radius: 10px; font-weight: 700; font-size: 0.9rem; color: #cbd5e1; cursor: pointer; list-style: none; transition: background-color .16s ease, color .16s ease, transform .16s ease; }
  .public-shell-nav a:hover, .public-shell-nav a.active, .public-shell-nav summary:hover, .public-shell-nav details[open] > summary { color: #fb923c; background: none; transform: translateY(-1px); }
  .public-shell-nav details { position: relative; }
  .public-shell-nav details > summary::-webkit-details-marker { display: none; }
  .public-shell-nav summary::after { content: '\25BE'; display: inline-block; margin-left: .35rem; font-size: .82em; line-height: 1; opacity: .8; transform: translateY(-1px); }
  .public-shell-nav details[open] > summary::after { transform: translateY(-1px) rotate(180deg); }
  .public-shell-nav-panel { position: absolute; top: calc(100% + .55rem); left: 0; min-width: 220px; padding: .45rem; background: #151b2c; border: 1px solid rgba(255,255,255,.08); border-radius: 16px; box-shadow: var(--shadow); display: grid; gap: .15rem; z-index: 5; }
  .public-shell-nav-panel a { padding: .7rem .8rem; border-radius: 12px; font-weight: 600; color: #e5e7eb; display: flex; align-items: center; gap: .6rem; }
  .public-shell-nav-panel a i, .public-shell-nav-panel a svg.lucide { width: 1rem; height: 1rem; text-align: center; color: #fb923c; flex: 0 0 auto; }
  .public-shell-nav-panel a:hover { background: rgba(255,255,255,.08); color: #fff; }
  .public-shell-actions { display: flex; gap: .6rem; align-items: center; }
  .public-shell-button { border-radius: 12px; font-weight: 700; min-height: 44px; padding: 0.65rem 1.1rem; letter-spacing: -0.01em; border-width: 1px; font-size: .9rem; }
  .public-shell-button.btn-primary { background: var(--cta-gradient); background-image: var(--cta-gradient); color: #fff; border-color: transparent; box-shadow: 0 10px 20px rgba(249, 115, 22, .3); }
  .public-shell-button.btn-primary:hover, .public-shell-button.btn-primary:focus { background: linear-gradient(135deg, #f97316 0%, #a855f7 100%); background-image: linear-gradient(135deg, #f97316 0%, #a855f7 100%); color: #fff; }
  .public-shell-button.btn-outline-primary { color: #e5e7eb; border: none; background: rgba(30,41,59,.9); }
  .public-shell-button.btn-outline-primary:hover, .public-shell-button.btn-outline-primary:focus { background: rgba(51,65,85,.9); color: #fff; }
  .container { max-width: 1280px !important; padding-left: 1rem; padding-right: 1rem; width: 100%; }
  @@media (min-width: 640px) { .container { padding-left: 1.5rem; padding-right: 1.5rem; } }
  @@media (min-width: 1024px) { .container { padding-left: 2rem; padding-right: 2rem; } }

  .public-shell-hamburger { display: none; background: none; border: none; color: #e5e7eb; padding: .5rem; cursor: pointer; min-width: 44px; min-height: 44px; align-items: center; justify-content: center; }
  @@media (max-width: 991.98px) { .public-shell-hamburger { display: flex; } }
  .mobile-menu-overlay { display: none; position: fixed; inset: 0; z-index: 100; background: rgba(0,0,0,.6); backdrop-filter: blur(4px); }
  .mobile-menu-overlay.is-open { display: block; }
  .mobile-menu-panel { position: fixed; top: 0; right: 0; bottom: 0; width: min(85vw, 360px); z-index: 101; background: linear-gradient(180deg, #151b2c 0%, #0f172a 100%); border-left: 1px solid rgba(255,255,255,.08); transform: translateX(100%); transition: transform .3s ease; overflow-y: auto; display: flex; flex-direction: column; padding: 1.5rem; }
  .mobile-menu-panel.is-open { transform: translateX(0); }
  .mobile-menu-close { display: flex; justify-content: flex-end; margin-bottom: 1rem; }
  .mobile-menu-close button { background: none; border: none; color: #e5e7eb; padding: .5rem; cursor: pointer; min-width: 44px; min-height: 44px; display: flex; align-items: center; justify-content: center; }
  .mobile-menu-section-label { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; padding: .6rem 0; }
  .mobile-menu-panel a { display: flex; align-items: center; min-height: 44px; padding: .75rem 0; color: #e5e7eb; text-decoration: none; font-size: 1.05rem; font-weight: 600; transition: color .2s; }
  .mobile-menu-panel a:hover { color: #fb923c; }
  .mobile-menu-panel a i, .mobile-menu-panel a svg.lucide { margin-right: .5rem; color: #fb923c; width: 1.2rem; height: 1.2rem; text-align: center; }
  .mobile-menu-panel .mobile-cta-btn { display: block; width: 100%; padding: 1rem; margin-top: 1rem; border-radius: 12px; font-weight: 800; font-size: 1rem; text-align: center; text-decoration: none; color: #fff; background: var(--cta-gradient); border: none; cursor: pointer; min-height: 56px; box-shadow: 0 14px 28px rgba(249, 115, 22, .24); }

  /* Page hero */
  .page-hero { padding: 6rem 0 2rem; text-align: center; }
  .page-hero h1 { font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 900; color: #fff; margin-bottom: .75rem; }
  .page-hero .gradient { background: var(--cta-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
  .page-hero p { color: #94a3b8; max-width: 650px; margin: 0 auto; font-size: 1.05rem; line-height: 1.7; }

  /* Sections */
  .section-dark { padding: 2.5rem 0; }
  .section-dark h2 { font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 800; color: #fff; text-align: center; margin-bottom: .5rem; }
  .section-sub { text-align: center; color: #94a3b8; max-width: 650px; margin: 0 auto 2rem; font-size: 1rem; line-height: 1.7; }
  .section-gradient { background: linear-gradient(to bottom, rgba(15,23,42,.4), rgba(17,24,39,.6)); }

  .faq-section-heading { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 1rem; padding-bottom: .5rem; border-bottom: 2px solid; border-image: linear-gradient(90deg, #f97316, #a855f7) 1; display: inline-block; }

  /* FAQ accordion */
  .faq-grid { max-width: 800px; margin: 0 auto; }
  .faq-item { background: rgba(15,23,42,.6); border: 1px solid rgba(255,255,255,.08); border-radius: 12px; margin-bottom: .5rem; overflow: hidden; transition: border-color .3s; }
  .faq-item:hover { border-color: rgba(255,255,255,.15); }
  .faq-item.open { border-color: rgba(249,115,22,.3); }
  .faq-q { padding: .85rem 1.25rem; color: #fff; font-weight: 600; font-size: .95rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: color .3s; }
  .faq-q:hover { color: #fb923c; }
  .faq-chevron { color: #94a3b8; font-size: 1.1rem; transition: transform .3s; flex-shrink: 0; margin-left: 1rem; }
  .faq-item.open .faq-chevron { transform: rotate(180deg); color: #fb923c; }
  .faq-a { padding: 0 1.25rem; color: #94a3b8; font-size: .9rem; line-height: 1.6; max-height: 0; overflow: hidden; transition: max-height .3s ease, padding .3s ease; }
  .faq-item.open .faq-a { max-height: 300px; padding: 0 1.25rem .85rem; }

  /* CTA */
  .cta-btn { display: inline-flex; align-items: center; gap: .5rem; padding: .9rem 2.25rem; border-radius: 12px; background: var(--cta-gradient); color: #fff; font-weight: 700; font-size: 1.05rem; text-decoration: none; transition: all .3s; box-shadow: 0 14px 28px rgba(249,115,22,.24); }
  .cta-btn:hover { transform: translateY(-2px); box-shadow: 0 20px 30px rgba(249,115,22,.3); color: #fff; }
  .contact-section { border-top: 3px solid; border-image: linear-gradient(135deg, #f97316, #ec4899) 1; background: linear-gradient(to right bottom, rgba(31,41,55,.6), rgba(17,24,39,.6)); text-align: center; }
  .contact-section .section-sub { margin-bottom: 2rem; }

  /* Footer */
  .public-shell-footer { padding: 1.5rem 0 1.2rem; color: #94a3b8; background: linear-gradient(135deg, #111827, #1f2937, #111827); border-top: 1px solid #1f293b; }
  .public-shell-footer .footer-topline, .public-shell-footer .footer-bottomline { height: 3px; width: 100%; border-radius: 999px; background: linear-gradient(90deg, rgba(249,115,22,0) 0%, rgba(249,115,22,.85) 18%, rgba(168,85,247,.95) 50%, rgba(236,72,153,.85) 82%, rgba(236,72,153,0) 100%); opacity: .95; }
  .public-shell-footer .footer-topline { margin-bottom: 1rem; }
  .public-shell-footer .footer-bottomline { margin-top: 1.5rem; margin-bottom: .75rem; }
  .public-shell-footer .footer-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1.5rem; align-items: start; }
  .public-shell-footer h3 { margin: 0 0 .75rem; font-size: .875rem; font-weight: 700; color: #fff; position: relative; padding-bottom: .75rem; }
  .public-shell-footer h3::after { content: ''; position: absolute; left: 0; bottom: 0; width: 32px; height: 2px; border-radius: 999px; background: var(--cta-gradient); }
  .public-shell-footer .footer-links a { display: block; padding: .35rem 0; color: #9ca3af; font-size: .75rem; line-height: 1.4; }
  .public-shell-footer .footer-links a:hover { color: #fff; }
  .public-shell-footer .footer-social { display: inline-flex; justify-content: center; align-items: center; gap: .5rem; }
  .public-shell-footer .footer-social a { width: 44px; height: 44px; border-radius: 999px; display: inline-flex; align-items: center; justify-content: center; background: #1f2937; color: #9ca3af; border: 1px solid rgba(255,255,255,.08); }
  .public-shell-footer .footer-social a:hover { background: rgba(249,115,22,.16); border-color: rgba(249,115,22,.24); color: #fff; }
  @@media (max-width: 991.98px) {
    .public-shell-topbar .inner { min-height: auto; flex-wrap: wrap; padding: .85rem 0; }
    .public-shell-brand { flex: 1 1 auto; }
    .public-shell-brand img { height: 26px; }
    .public-shell-actions { display: none; }
    .public-shell-footer .footer-grid { grid-template-columns: 1fr 1fr; gap: 1.1rem; }
    .public-shell-footer .footer-bottom { align-items: center; text-align: center; }
  }
  @@media (max-width: 767.98px) {
    .section-dark { padding: 1.25rem 0; }
    .page-hero { padding: 4rem 0 1.5rem; }
  }
  </style>
<meta property="og:title" content="FAQ - FansFollow.me">
<meta property="og:description" content="Frequently asked questions about FansFollow &#8212; creator earnings, payments, and platform features.">
<meta property="og:image" content="/public/logo-full-lockup.png">
<meta property="og:url" content="https://fansfollowme.com/faq.html">
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
        <details class="public-shell-more">
          <summary>More</summary>
          <div class="public-shell-nav-panel">
            <a href='{{ route('page.casting') }}'>&#127912; <span>Movie Casting</span></a>
            <a href='{{ route('page.live-streams') }}'>&#128308; <span>Live Streams</span></a>
            <a href='{{ route('page.business') }}'>&#128188; <span>Business</span></a>
            <a href='{{ route('page.support') }}'>&#128172; <span>Support</span></a>
@auth
                            @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
                            <a href='{{ route('join.my-qr') }}'>&#128241; <span>My QR code</span></a>
                            @endif
                            @endauth
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
    <div class="mobile-menu-section-label" style="margin-top:.5rem">More</div>
    <a href='{{ route('page.casting') }}'>&#127912; Movie Casting</a>
    <a href='{{ route('page.live-streams') }}'>&#128308; Live Streams</a>
    <a href='{{ route('page.business') }}'>&#128188; Business</a>
    <a href='{{ route('page.support') }}'>&#128172; Support</a>
@auth
    @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
    <a href='{{ route('join.my-qr') }}'>&#128241; My QR code</a>
    @endif
    @endauth
    <a href='{{ route('login') }}' style='margin-top:1rem;color:#94a3b8;font-weight:600'>Login</a>
    <a class='mobile-cta-btn' href='{{ route('register') }}'>Get Started</a>
  </div>

  <main class="public-shell-content">
    <section class="page-hero">
      <div class="container">
        <h1>Frequently Asked <span class="gradient">Questions</span></h1>
        <p>Everything you need to know about FansFollow &#8212; creator earnings, payments, and platform features.</p>
      </div>
    </section>

    <section class="section-dark">
      <div class="container">
        <div class="faq-grid">
          <h2 class="faq-section-heading">Getting Started</h2>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">How much does it cost to join as a creator?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Free to join. We only earn when you earn (20% platform fee). No monthly fees, no hidden costs.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">How much does it cost for fans?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Free to create an account. Fans only pay for premium content, subscriptions, or services they choose to purchase from creators.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">Do I need a large following to start earning?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">No. Creators with 1K-5K followers earn $5K-20K/month. Followers can also earn through our referral program. Quality engagement matters more than follower count.</div></div>
        </div>
      </div>
    </section>

    <section class="section-dark section-gradient">
      <div class="container">
        <div class="faq-grid">
          <h2 class="faq-section-heading">Payments &amp; Earnings</h2>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">How do I get paid?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Bank transfer, PayPal, or crypto (BTC, ETH, USDT, SOL). Payouts processed within 5 business days.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">What's the revenue split?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Creators keep 80%+ of earnings. VIP creators with large followings can negotiate custom rates even higher.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">What are the revenue streams?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">17+ options including subscriptions, tips, PPV content, phone calls, text coaching, video consultations, digital products, and more.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">How often do I get paid?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Withdraw earnings anytime (minimum $50). Payouts processed within 5 business days.</div></div>
        </div>
      </div>
    </section>

    <section class="section-dark">
      <div class="container">
        <div class="faq-grid">
          <h2 class="faq-section-heading">Platform Features</h2>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">Can I use this alongside other platforms?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Absolutely! We don't require exclusivity. Many creators use FansFollow plus Instagram, YouTube, Patreon, etc.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">What countries are supported?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">We support creators and fans worldwide. Crypto payments work globally without banking restrictions.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">Is my content safe and secure?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Yes. Encrypted communications, secure payment processing, and you control who sees your content.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">What kind of content can I post?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Fitness, nutrition, bodybuilding, martial arts, combat sports, training programs, coaching content, and related topics.</div></div>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">Can I offer private coaching or consultations?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">Yes! Paid phone calls, text coaching, video sessions, and personalized training programs are core features.</div></div>
        </div>
      </div>
    </section>

    <section class="section-dark section-gradient">
      <div class="container">
        <div class="faq-grid">
          <h2 class="faq-section-heading">Technical</h2>
          <div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">Is there a mobile app?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">iOS and Android apps are in development and launching soon. Currently use the mobile-responsive website.</div></div>
        </div>
      </div>
    </section>

    <section class="section-dark contact-section">
      <div class="container">
        <h2>Still have questions?</h2>
        <p class="section-sub">Our support team is here to help. Reach out anytime.</p>
        <a class='cta-btn' href='{{ route('page.contact') }}'>Contact Support</a>
      </div>
    </section>
  </main>

  <footer class="public-shell-footer">
    <div class="container">
      <div class="footer-topline"></div>
      <div class="footer-grid" style="gap: 2rem;">
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">For Creators</h3>
          <a href="{{ route('page.revenue-streams') }}" style='font-size: .9rem;'>Revenue Streams</a>
          @if (auth()->check() && (auth()->user()->isCreator() || auth()->user()->isAdmin()))
          <a href="{{ route('join.my-qr') }}" style='font-size: .9rem;'>In-Person QR Sign-Ups</a>
          @else
          <a href="{{ route('register') }}?role=creator" style='font-size: .9rem;'>In-Person QR Sign-Ups</a>
          @endif
          <a href="{{ route('register') }}?role=creator" style='font-size: .9rem;'>Getting Started</a>
          <a href="{{ route('page.for-creators') }}" style='font-size: .9rem;'>Personal Video Messages</a>
        </div>
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Revenue Streams</h3>
          <a href="{{ route('page.for-creators') }}" style='font-size: .9rem;'>Content Monetization</a>
          <a href="{{ route('page.for-creators') }}" style='font-size: .9rem;'>Paid Phone Calls</a>
          <a href="{{ route('page.for-creators') }}" style='font-size: .9rem;'>Text Coaching</a>
          <a href="{{ route('page.for-creators') }}" style='font-size: .9rem;'>Video Consultations</a>
        </div>
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Support</h3>
          <a href="{{ route('page.support') }}" style='font-size: .9rem;'>Help Center</a>
          <a href="{{ route('page.contact') }}" style='font-size: .9rem;'>Contact Us</a>
          <a href="{{ route('page.faq') }}" style='font-size: .9rem;'>FAQ</a>
        </div>
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Coming Soon</h3>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Creator Competitions</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Gym Monster</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Mini Leagues</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Mobile App</span>
        </div>
      </div>
      <div class="footer-bottomline"></div>
      <div class="footer-bottom footer-bottom--2row">
        <div class="footer-legal footer-legal--row">
          <span style="font-size: .85rem; color: #94a3b8;">&copy; 2026 FansFollow.me. All rights reserved.</span>
          <span style="color: #4b5563;">&bull;</span>
          <span style="font-size: .85rem; color: #94a3b8;"><span class="btc-mark" style="color: #f97316; font-weight: 800;">&#8383;</span> <strong style="color: #fff;">BTC/ETH/USDT/SOL Accepted</strong></span>
          <span style="color: #4b5563;">&bull;</span>
          <a href="{{ route('page.privacy') }}" style='font-size: .85rem; color: #94a3b8;'>Privacy Policy</a>
          <span style="color: #4b5563;">&bull;</span>
          <a href="{{ route('page.terms') }}" style='font-size: .85rem; color: #94a3b8;'>Terms of Service</a>
          <span style="color: #4b5563;">&bull;</span>
          <a href="{{ route('page.cookies') }}" style='font-size: .85rem; color: #94a3b8;'>Cookie Policy</a>
          <span style="color: #4b5563;">&bull;</span>
          <a href="{{ route('page.faq') }}" style='font-size: .85rem; color: #94a3b8;'>FAQ</a>
        </div>
        <div class="footer-follow footer-follow--row">
          <span style="font-size: .85rem; color: #94a3b8;">Follow us:</span>
          <div class="footer-social" style="display: flex; gap: .5rem;" aria-label="Social links">
            <a href="https://www.facebook.com/profile.php?id=100089966703593" target="_blank" rel="noopener" aria-label="Facebook" style="color: #94a3b8;"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
            <a href="https://www.instagram.com/fansfollowdotme" target="_blank" rel="noopener" aria-label="Instagram" style="color: #94a3b8;"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.012-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
            <a href="https://www.youtube.com/@FFMFansFollowME" target="_blank" rel="noopener" aria-label="YouTube" style="color: #94a3b8;"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.016 3.016 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
            <a href="https://www.tiktok.com/@fansfollow.me" target="_blank" rel="noopener" aria-label="TikTok" style="color: #94a3b8;"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

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
