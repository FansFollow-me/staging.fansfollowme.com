{{-- PIXEL-EXACT port from signed-off https://fansfollowme.com (privacy)
     Do NOT restyle. Auth forms/routes only. --}}
<!doctype html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="FansFollow.me Privacy Policy">
  <link rel="canonical" href="https://fansfollowme.com/privacy.html">
  <meta name="keywords" content="donations,support,creators,content creators,subscription,content" />
  <meta name="theme-color" content="#f97316">
  <title>Privacy - FansFollow.me</title>
  <link href="data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 64 64%27%3E%3Crect width=%2764%27 height=%2764%27 rx=%2712%27 fill=%27%230d1119%27/%3E%3Ctext x=%2732%27 y=%2744%27 font-size=%2736%27 font-weight=%27bold%27 text-anchor=%27middle%27 fill=%27%23f97316%27 font-family=%27Arial,sans-serif%27%3EF%3C/text%3E%3C/svg%3E" rel="icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/ffm-mobile-spacing.css') }}?v=ffm3" rel="stylesheet">
  <style>
    :root {
      color-scheme: dark;
      --bg: #0b0f1a;
      --panel: #151b2c;
      --text: #e5e7eb;
      --muted: #94a3b8;
      --line: rgba(255, 255, 255, 0.08);
      --accent: #60a5fa;
      --accent-2: #e5e7eb;
      --shadow: 0 18px 54px rgba(0, 0, 0, 0.36);
      --cta-gradient: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%);
    }

    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      margin: 0;
      background-color: var(--bg);
      background-image: none;
      color: var(--text);
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      font-weight: 400;
      overflow-x: clip;
      overflow-wrap: break-word;
      word-break: break-word;
    }
    a { color: inherit; text-decoration: none; }
    img { max-width: 100%; display: block; }
    h1, h2, h3, h4, h5, h6 { font-family: 'Inter', sans-serif; color: var(--text); }

    .public-shell-topbar {
      position: sticky;
      top: 0;
      z-index: 40;
      background: transparent;
      border-bottom: 0;
      box-shadow: none;
      transition: background .3s, border-color .3s, box-shadow .3s;
    }
    .public-shell-topbar.scrolled {
      background: rgba(11,15,26,0.82);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid rgba(255,255,255,.06);
      box-shadow: 0 4px 16px rgba(0,0,0,.15);
    }
    .public-shell-topbar .inner {
      min-height: 72px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
    }
    .public-shell-brand img { height: 30px; width: auto; }
    .public-shell-nav {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 0.15rem;
    }
    .public-shell-nav a, .public-shell-nav summary {
      padding: 0.5rem 0.7rem;
      border-radius: 10px;
      font-weight: 700;
      font-size: 0.9rem;
      color: #cbd5e1;
      cursor: pointer;
      list-style: none;
      transition: background-color .16s ease, color .16s ease, transform .16s ease;
    }
    .public-shell-nav a:hover,
    .public-shell-nav a.active,
    .public-shell-nav summary:hover,
    .public-shell-nav details[open] > summary {
      color: #fb923c;
      background: none;
      transform: translateY(-1px);
    }
    .public-shell-nav details { position: relative; }
    .public-shell-nav details > summary::-webkit-details-marker { display: none; }
    .public-shell-nav summary::after {
      content: '\25BE';
      display: inline-block;
      margin-left: .35rem;
      font-size: .82em;
      line-height: 1;
      opacity: .8;
      transform: translateY(-1px);
    }
    .public-shell-nav details[open] > summary::after {
      transform: translateY(-1px) rotate(180deg);
    }
    .public-shell-nav-panel {
      position: absolute;
      top: calc(100% + .55rem);
      left: 0;
      min-width: 220px;
      padding: .45rem;
      background: #151b2c;
      border: 1px solid rgba(255,255,255,.08);
      border-radius: 16px;
      box-shadow: var(--shadow);
      display: grid;
      gap: .15rem;
      z-index: 5;
    }
    .public-shell-nav-panel a {
      padding: .7rem .8rem;
      border-radius: 12px;
      font-weight: 600;
      color: #e5e7eb;
      display: flex;
      align-items: center;
      gap: .6rem;
    }
    .public-shell-nav-panel a i,
    .public-shell-nav-panel a svg.lucide {
      width: 1rem;
      height: 1rem;
      text-align: center;
      color: #fb923c;
      flex: 0 0 auto;
    }
    .public-shell-nav-panel a:hover {
      background: rgba(255,255,255,.08);
      color: #fff;
    }
    .public-shell-actions { display: flex; gap: .6rem; align-items: center; }
    .public-shell-button {
      border-radius: 12px;
      font-weight: 700;
      min-height: 44px;
      padding: 0.65rem 1.1rem;
      letter-spacing: -0.01em;
      border-width: 1px;
      font-size: .9rem;
    }
    .public-shell-button.btn-primary {
      background: var(--cta-gradient);
      background-image: var(--cta-gradient);
      color: #fff;
      border-color: transparent;
      box-shadow: 0 10px 20px rgba(249, 115, 22, .3);
    }
    .public-shell-button.btn-primary:hover,
    .public-shell-button.btn-primary:focus {
      background: linear-gradient(135deg, #f97316 0%, #a855f7 100%);
      background-image: linear-gradient(135deg, #f97316 0%, #a855f7 100%);
      color: #fff;
    }
    .public-shell-button.btn-outline-primary {
      color: #e5e7eb;
      border: none;
      background: rgba(30,41,59,.9);
    }
    .public-shell-button.btn-outline-primary:hover,
    .public-shell-button.btn-outline-primary:focus {
      background: rgba(51,65,85,.9);
      color: #fff;
    }
    .public-shell-content { padding: 0; }
    .container,
    .container-fluid,
    .container-sm,
    .container-md,
    .container-lg,
    .container-xl {
      max-width: 1280px !important;
    }
    .container {
      padding-left: 1rem;
      padding-right: 1rem;
    }
    @@media (min-width: 640px) { .container { padding-left: 1.5rem; padding-right: 1.5rem; } }
    @@media (min-width: 1024px) { .container { padding-left: 2rem; padding-right: 2rem; } }

    /* Page shell / hero / card / content &#8212; legal page template */
    .page-shell {
      padding: 4rem 0 5rem;
      background: transparent;
    }
    .page-hero {
      margin-bottom: 1.5rem;
    }
    .page-hero .eyebrow {
      color: #60a5fa;
      text-transform: uppercase;
      font-size: 0.82rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
    }
    .page-hero h1 {
      margin: 0 0 0.75rem;
      font-size: clamp(2rem, 3vw, 3rem);
      line-height: 1.05;
      letter-spacing: 0;
      color: #e5e7eb;
    }
    .page-hero p {
      margin: 0;
      max-width: 60rem;
      color: #cbd5e1;
      line-height: 1.6;
    }
    .page-card {
      background: rgba(15, 23, 42, 0.88);
      border: 1px solid rgba(148, 163, 184, 0.14);
      border-radius: 16px;
      box-shadow: 0 22px 60px rgba(0, 0, 0, 0.24);
      padding: 1.5rem;
    }
    .page-content {
      color: #e5e7eb;
      line-height: 1.75;
    }
    .page-content h2,
    .page-content h3,
    .page-content h4 {
      margin-top: 1.5rem;
    }
    .page-content p:last-child {
      margin-bottom: 0;
    }
    .page-content a {
      color: #60a5fa;
    }
    .page-content img {
      max-width: 100%;
      height: auto;
      border-radius: 12px;
    }

    /* Footer */
    .public-shell-footer {
      padding: 1.5rem 0 1.2rem;
      color: var(--muted);
      background: linear-gradient(135deg, #111827, #1f2937, #111827);
      border-top: 1px solid #1f293b;
    }
    .public-shell-footer .footer-topline,
    .public-shell-footer .footer-bottomline {
      height: 3px;
      width: 100%;
      border-radius: 999px;
      background: linear-gradient(90deg, rgba(249,115,22,0) 0%, rgba(249,115,22,.85) 18%, rgba(168,85,247,.95) 50%, rgba(236,72,153,.85) 82%, rgba(236,72,153,0) 100%);
      opacity: .95;
    }
    .public-shell-footer .footer-topline { margin-bottom: 1rem; }
    .public-shell-footer .footer-bottomline { margin-top: 1.5rem; margin-bottom: .75rem; }
    .public-shell-footer .footer-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 1.5rem;
      align-items: start;
    }
    .public-shell-footer h3 {
      margin: 0 0 .75rem;
      font-size: .875rem;
      font-weight: 700;
      color: #fff;
      position: relative;
      padding-bottom: .75rem;
    }
    .public-shell-footer h3::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 32px;
      height: 2px;
      border-radius: 999px;
      background: var(--cta-gradient);
    }
    .public-shell-footer .footer-links a { display: block; padding: .35rem 0; color: #9ca3af; font-size: .75rem; line-height: 1.4; }
    .public-shell-footer .footer-links a:hover { color: #fff; }
    .public-shell-footer .footer-social {
      display: inline-flex;
      justify-content: center;
      align-items: center;
      gap: .5rem;
    }
    .public-shell-footer .footer-social a {
      width: 44px;
      height: 44px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: #1f2937;
      color: #9ca3af;
      border: 1px solid rgba(255,255,255,.08);
    }
    .public-shell-footer .footer-social a:hover {
      background: rgba(249,115,22,.16);
      border-color: rgba(249,115,22,.24);
      color: #fff;
    }

    /* Hamburger */
    .public-shell-hamburger {
      display: none;
      background: none;
      border: none;
      color: #e5e7eb;
      padding: .5rem;
      cursor: pointer;
      min-width: 44px;
      min-height: 44px;
      align-items: center;
      justify-content: center;
    }
    @@media (max-width: 991.98px) {
      .public-shell-hamburger { display: flex; }
      .public-shell-topbar .inner {
        min-height: auto;
        flex-wrap: wrap;
        padding: .85rem 0;
      }
      .public-shell-brand { flex: 1 1 auto; }
      .public-shell-brand img { height: 26px; }
      .public-shell-actions { display: none; }
      .public-shell-footer { padding: 2rem 0 1.5rem; }
      .public-shell-footer .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 1.1rem;
      }
      .public-shell-footer .footer-bottom {
        align-items: center;
        text-align: center;
      }
    }
    @@media (max-width: 767.98px) {
      .page-shell { padding: 2rem 0 2.5rem; }
    }

    /* Mobile menu */
    .mobile-menu-overlay {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 100;
      background: rgba(0,0,0,.6);
      backdrop-filter: blur(4px);
    }
    .mobile-menu-overlay.is-open { display: block; }
    .mobile-menu-panel {
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      width: min(85vw, 360px);
      z-index: 101;
      background: linear-gradient(180deg, #151b2c 0%, #0f172a 100%);
      border-left: 1px solid rgba(255,255,255,.08);
      transform: translateX(100%);
      transition: transform .3s ease;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      padding: 1.5rem;
    }
    .mobile-menu-panel.is-open { transform: translateX(0); }
    .mobile-menu-close {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 1rem;
    }
    .mobile-menu-close button {
      background: none;
      border: none;
      color: #e5e7eb;
      padding: .5rem;
      cursor: pointer;
      min-width: 44px;
      min-height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .mobile-menu-section-label {
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: #64748b;
      padding: .6rem 0;
    }
    .mobile-menu-panel a {
      display: flex;
      align-items: center;
      min-height: 44px;
      padding: .75rem 0;
      color: #e5e7eb;
      text-decoration: none;
      font-size: 1.05rem;
      font-weight: 600;
      transition: color .2s;
    }
    .mobile-menu-panel a:hover { color: #fb923c; }
    .mobile-menu-panel a i,
    .mobile-menu-panel a svg.lucide {
      margin-right: .5rem;
      color: #fb923c;
      width: 1.2rem;
      height: 1.2rem;
      text-align: center;
    }
    .mobile-menu-panel .mobile-cta-btn {
      display: block;
      width: 100%;
      padding: 1rem;
      margin-top: 1rem;
      border-radius: 12px;
      font-weight: 800;
      font-size: 1rem;
      text-align: center;
      text-decoration: none;
      color: #fff;
      background: var(--cta-gradient);
      border: none;
      cursor: pointer;
      min-height: 56px;
      box-shadow: 0 14px 28px rgba(249, 115, 22, .24);
    }
  </style>
<meta property="og:title" content="Privacy - FansFollow.me">
<meta property="og:description" content="FansFollow.me Privacy Policy">
<meta property="og:image" content="/public/logo-full-lockup.png">
<meta property="og:url" content="https://fansfollowme.com/privacy.html">
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
    <a href='{{ route('login') }}' style='margin-top:1rem;color:#94a3b8;font-weight:600'>Login</a>
    <a class='mobile-cta-btn' href='{{ route('register') }}'>Get Started</a>
  </div>

  <main class="public-shell-content">
    <section class="page-shell">
      <div class="container">
        <div class="page-hero">
          <div class="eyebrow">FansFollow.me</div>
          <h1>Privacy</h1>
          <p>FansFollow.me Privacy Policy</p>
        </div>
        <div class="page-card">
          <div class="page-content content-p">
            <ol>
              <li>
                <p>Introduction At FansFollow.me, we are committed to protecting your privacy and personal information. This Privacy Policy (the &quot;Policy&quot;) explains how we collect, use, and disclose your personal information when you use our website and services (the &quot;Services&quot;). By using the Services, you consent to the collection, use, and disclosure of your personal information as described in this Policy.</p>
              </li>
              <li>
                <p>Information We Collect We may collect the following types of personal information:</p>
              </li>
            </ol>

            <ul>
              <li>Information you provide to us: When you create an account, we may collect your name, email address, and other contact information. If you contact us for customer support, we may collect information about your account and the issue you are experiencing.</li>
              <li>Information we collect automatically: We may collect information about your device and browser, such as IP address, browser type, and operating system. We may also collect information about your usage of the Services, such as the pages you visit and the actions you take.</li>
              <li>Information we collect from third-party services: We may collect information about you from other online services, such as social media platforms, if you choose to connect your account to those services.</li>
            </ul>

            <ol>
              <li>Use of Information We use the information we collect for the following purposes:</li>
            </ol>

            <ul>
              <li>To provide and improve the Services: We use the information we collect to provide and improve the features and functionality of the Services.</li>
              <li>To communicate with you: We may use your contact information to send you important notices and updates about the Services, such as changes to our terms of service.</li>
              <li>To personalize your experience: We may use the information we collect to personalize your experience on the Services, such as showing you content that we believe will be of interest to you.</li>
              <li>For research and analytics: We may use the information we collect to conduct research and analysis to improve the Services.</li>
            </ul>

            <ol>
              <li>Disclosure of Information We may disclose your personal information to the following parties:</li>
            </ol>

            <ul>
              <li>Service providers: We may share your information with third-party service providers who assist us in providing the Services, such as hosting providers and analytics companies.</li>
              <li>Law enforcement and government agencies: We may disclose your information to law enforcement and government agencies in response to a legal request or to protect the rights and safety of the Services or its users.</li>
              <li>Business transfers: In the event that we sell or transfer all or a portion of our business or assets, we may disclose your personal information as part of that transaction.</li>
            </ul>

            <ol>
              <li>
                <p>Data Retention We will retain your personal information for as long as your account is active or as needed to provide the Services. We will also retain and use your information as necessary to comply with legal obligations, resolve disputes, and enforce our agreements.</p>
              </li>
              <li>
                <p>Security We take the security of your personal information seriously and have implemented measures to protect your information from unauthorized access, use, or disclosure. However, no method of transmission over the Internet or electronic storage is 100% secure, and we cannot guarantee the security of your personal information.</p>
              </li>
              <li>
                <p>Changes to this Policy We may make changes to this Policy from time to time. We will notify you of any changes by posting the new Policy on the Services and updating the &quot;Effective Date&quot; at the top of this Policy. Your continued use of the Services after any changes to this Policy constitutes your acceptance of the new Policy.</p>
              </li>
              <li>
                <p>Contact Us If you have any questions or concerns about this Policy, please contact us at via the contact page.</p>
              </li>
            </ol>

            <p>By using FansFollow.me, you acknowledge that you have read and understand this Privacy Policy and agree to be bound by it.</p>
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
          <h2 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">For Creators</h3>
          <a href='{{ route('register') }}' style='font-size: .9rem;'>Getting Started</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Personal Video Messages</a>
        </div>
        <div class="footer-links">
          <h2 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Revenue Streams</h3>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Content Monetization</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Paid Phone Calls</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Text Coaching</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Video Consultations</a>
        </div>
        <div class="footer-links">
          <h2 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Support</h3>
          <a href='{{ route('page.support') }}' style='font-size: .9rem;'>Help Center</a>
          <a href='{{ route('page.contact') }}' style='font-size: .9rem;'>Contact Us</a>
          <a href='{{ route('page.for-creators') }}' style='font-size: .9rem;'>Creator Resources</a>
          <a href='{{ route('page.contact') }}' style='font-size: .9rem;'>Community</a>
        </div>
        <div class="footer-links">
          <h2 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Coming Soon</h3>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Creator Competitions</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Gym Monster</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Mini Leagues</span>
          <span style="font-size: .9rem; color: #94a3b8; display: block;">Mobile App</span>
          <!-- TOKEN-LINK-RESTORE: <a href='/business#token' style='font-size: .9rem;'>Token Ecosystem</a> -->
          <!-- PRESALE-LINK-RESTORE: <a href='/business#presale' style='font-size: .9rem;'>Presale Info</a> -->
        </div>
      </div>
      <div class="footer-bottomline"></div>
      <div class="footer-bottom">
        <div class="footer-legal"><span style="font-size: .85rem; color: #94a3b8;">© 2026 FansFollow.me. All rights reserved.</span>
          <span style="font-size: .85rem; color: #94a3b8;"><span style="color: #f97316; font-weight: 800;">₿</span> <strong style="color: #fff;">BTC/ETH/USDT/SOL Accepted</strong></span></div>
        <div class="footer-policies"><a href='{{ route('page.privacy') }}' style='font-size: .85rem; color: #94a3b8;'>Privacy Policy</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='{{ route('page.terms') }}' style='font-size: .85rem; color: #94a3b8;'>Terms of Service</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='{{ route('page.cookies') }}' style='font-size: .85rem; color: #94a3b8;'>Cookie Policy</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='{{ route('page.faq') }}' style='font-size: .85rem; color: #94a3b8;'>FAQ</a></div>
        <div class="footer-follow">
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
