{{-- PIXEL-EXACT homepage from signed-off https://fansfollowme.com
     Do NOT restyle. Only auth-aware nav + Laravel routes differ from static mockup. --}}
<!doctype html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="FansFollow.me is the global fitness and martial arts creator platform for subscriptions, coaching, direct fan access, and live creator discovery.">
  <link rel="canonical" href="https://fansfollowme.com/">
    <meta name="keywords" content="donations,support,creators,content creators,subscription,content" />
  <meta name="theme-color" content="#450ea7">
  <meta name="msvalidate.01" content="83E04AABA8CC0BC0618D1849666A133A">
  <title> FansFollow.me - Global Fitness & Martial Arts Creator Platform</title>
  <link href="data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 64 64%27%3E%3Crect width=%2764%27 height=%2764%27 rx=%2712%27 fill=%27%230d1119%27/%3E%3Ctext x=%2732%27 y=%2744%27 font-size=%2736%27 font-weight=%27bold%27 text-anchor=%27middle%27 fill=%27%23f97316%27 font-family=%27Arial,sans-serif%27%3EF%3C/text%3E%3C/svg%3E" rel="icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#f97316">
  <link rel="apple-touch-icon" href="/public/logo-monogram.png">
  <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
  <link href="{{ asset('css/ffm-mobile-spacing.css') }}?v=ffm1" rel="stylesheet">
  <style>
  :root {
    color-scheme: dark;
    --ffm-text: #e5e7eb;
    --ffm-muted: #94a3b8;
    --ffm-line: rgba(148, 163, 184, 0.14);
    --ffm-accent: #60a5fa;
  }

  html, :root {
    scroll-behavior: auto !important;
    overscroll-behavior: auto;
    overflow-x: clip;
  }

  body {
    overflow-x: clip;
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-weight: 400;
    color: var(--ffm-text);
    background-color: #020617;
    background-image: none;
  }

  /* Font weight scale */
  .fw-regular { font-weight: 400; }
  .fw-medium { font-weight: 500; }
  .fw-semibold { font-weight: 600; }
  .fw-bold { font-weight: 700; }
  .fw-black { font-weight: 900; }

  h1, h2, h3, h4, h5, h6 { font-family: 'Inter', sans-serif; color: var(--ffm-text); }
  h1 { font-weight: 900; }
  h2 { font-weight: 800; }
  h3, h4 { font-weight: 700; }
  h5, h6 { font-weight: 600; }

  a {
    text-decoration: none;
    color: var(--ffm-accent);
  }
  .media-heading a,
  .media-heading {
    color: var(--ffm-text) !important;
  }

  img {
    max-width: 100%;
    height: auto;
  }

  .navbar-brand img,
  .logo {
    max-height: 44px;
    width: auto;
  }

  .btn {
    border-radius: 999px;
    font-weight: 700;
  }

  /* Compensate for fixed-top navbar on logged-in Sponzy pages */
  body > header:has(nav.fixed-top) ~ main {
    padding-top: 95px;
  }
  @@media (min-width: 992px) {
    body > header:has(nav.fixed-top) ~ main {
      padding-top: 70px;
    }
  }

  /* Dark theme for mobile navbar collapse */
  @@media (max-width: 991.98px) {
    .navbar .navbar-collapse {
      background: #0b0f1a !important;
      padding-top: 1rem !important;
    }
    .navbar .navbar-collapse .navbar-nav .nav-item .nav-link:not(.btn) {
      color: #e2e8f0 !important;
    }
    .navbar .navbar-collapse .close-menu-mobile {
      color: #e2e8f0 !important;
    }
    .navbar .navbar-collapse .search-bar {
      background: rgba(15, 23, 42, 0.8) !important;
      color: #e2e8f0 !important;
      border-color: rgba(148, 163, 184, 0.18) !important;
    }
    .navbar .navbar-collapse .search-bar::placeholder {
      color: #94a3b8 !important;
    }
    .navbar .navbar-collapse .link-menu-mobile {
      color: #e2e8f0 !important;
    }
  }

  /* Fix mobile bottom nav to bottom of screen */
  .menuMobile {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1020;
    background: rgba(15, 23, 42, 0.95) !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-top: 1px solid rgba(148, 163, 184, 0.12);
    padding-bottom: env(safe-area-inset-bottom, 0);
  }

  /* Hide mobile bottom nav on desktop */
  @@media (min-width: 992px) {
    .menuMobile {
      display: none !important;
    }
  }

  /* Bottom nav: ensure page content isn't cut off */
  @@media (max-width: 991.98px) {
    main {
      padding-bottom: 60px !important;
    }
  }

  #mobileMenuOverlay {
    position: fixed;
    inset: 0;
    background: rgba(2, 6, 23, 0.58);
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s ease;
    z-index: 1039;
  }

  body.sidebar-overlay #mobileMenuOverlay {
    opacity: 1;
    pointer-events: auto;
  }

  /* Ensure navbar collapse sits above overlay on mobile */
  @@media (max-width: 991.98px) {
    #navbarCollapse.show {
      z-index: 10000 !important;
    }
  }

  /* Safety: overlay dismissed on outside click */
  #mobileMenuOverlay { cursor: pointer; }

  @@media (min-width: 992px) {
    #mobileMenuOverlay {
      display: none;
    }
  }

  .form-control,
  .custom-select,
  .input-group-text,
  .card,
  .panel,
  .modal-content {
    border-radius: 12px;
  }

  .card,
  .panel,
  .modal-content {
    background: rgba(15, 23, 42, 0.82) !important;
    color: var(--ffm-text) !important;
    border: 1px solid var(--ffm-line) !important;
    box-shadow: 0 12px 36px rgba(15, 23, 42, 0.06);
  }

  .text-muted {
    color: #cbd5e1 !important;
  }

  /* â”€â”€ Creator name in post cards â”€â”€ */
  .card-updates h5 a,
  .card-updates .font-montserrat a {
    color: #f1f5f9 !important;
  }
  .card-updates h5 a:hover,
  .card-updates .font-montserrat a:hover {
    color: #fff !important;
  }

  /* â”€â”€ Post image: maintain aspect ratio â”€â”€ */
  .img-video-wrap .post-image {
    object-fit: contain !important;
  }
  .post-img-grid {
    position: absolute;
    display: block;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* â”€â”€ Broken image fallback â”€â”€ */
  .card-updates img,
  .update-media img {
    background: rgba(30, 41, 59, 0.6);
    min-height: 40px;
  }
  .card-updates img:not([src]),
  .card-updates img[src=""] {
    display: none;
  }

  /* â”€â”€ Locked post grey bar fix â”€â”€ */
  .content-locked {
    background: rgba(15, 23, 42, 0.82) !important;
    color: #e2e8f0 !important;
  }

  /* â”€â”€ Post caption text brightness â”€â”€ */
  .update-text,
  .update-text p,
  .update-text span,
  .update-text div {
    color: #f1f5f9 !important;
  }

  .bg-white {
    background-color: rgba(15,23,42,.82) !important;
    color: #e2e8f0 !important;
  }
  .bg-white img {
    filter: brightness(1.2);
  }

  /* â”€â”€ Navbar dark theme â”€â”€ */
  .navbar_background_color,
  nav.navbar {
    background: rgba(15, 23, 42, 0.92) !important;
    backdrop-filter: blur(18px);
    border-bottom: 1px solid rgba(148, 163, 184, 0.12);
  }
  nav.navbar .navbar-brand img { filter: brightness(1.2); }
  nav.navbar .nav-link,
  nav.navbar .icon-navbar {
    color: #e2e8f0 !important;
  }
  nav.navbar .nav-link:hover {
    color: #fb923c !important;
  }
  nav.navbar .search-bar {
    background: rgba(51, 65, 85, 0.6) !important;
    border: 1px solid rgba(148, 163, 184, 0.18) !important;
    color: #e2e8f0 !important;
  }
  nav.navbar .search-bar::placeholder { color: #9ca3af !important; }
  nav.navbar .dropdown-menu {
    background: #151b2c !important;
    border: 1px solid rgba(148, 163, 184, 0.12) !important;
    box-shadow: 0 16px 50px rgba(0, 0, 0, 0.45) !important;
  }
  nav.navbar .dropdown-item {
    color: #e2e8f0 !important;
  }
  nav.navbar .dropdown-item:hover {
    background: rgba(249, 115, 22, 0.14) !important;
    color: #fb923c !important;
  }
  nav.navbar .dropdown-divider {
    border-color: rgba(148, 163, 184, 0.12) !important;
  }
  .icon-navbar { color: #94a3b8; }

  /* â”€â”€ Left sidebar (menu-left-home) â”€â”€ */
  .menu-left-home {
    background: rgba(15, 23, 42, 0.84);
    border: 1px solid rgba(148, 163, 184, 0.12);
    border-radius: 16px;
    padding: 0.75rem 0;
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.18);
    list-style: none;
    margin: 0;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
    z-index: auto !important;
  }

  /* â”€â”€ Right sidebar: prevent footer from hiding behind fixed bottom nav â”€â”€ */
  .col-md-4 .sticky-top.d-lg-block {
    padding-bottom: 70px !important;
    z-index: auto !important;
  }
  .menu-left-home li a {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.65rem 1rem;
    color: rgba(226, 232, 240, 0.82);
    font-weight: 600;
    font-size: 0.9rem;
    border-radius: 10px;
    margin: 0 0.4rem;
    transition: background 0.16s, color 0.16s;
  }
  .menu-left-home li a:hover,
  .menu-left-home li a.active {
    background: rgba(249, 115, 22, 0.14);
    color: #fb923c;
  }
  .menu-left-home li a i {
    font-size: 1rem;
    width: 1.2rem;
    text-align: center;
  }

  /* â”€â”€ Notification cards dark theme â”€â”€ */
  .notifications-page .card,
  .notifications-page .list-group-item,
  .card-notification,
  .card-settings,
  .card.shadow-sm,
  .list-group-item {
    background: rgba(15, 23, 42, 0.82) !important;
    color: #e2e8f0 !important;
    border-color: rgba(148, 163, 184, 0.12) !important;
  }
  .notifications-page .card:hover,
  .list-group-item:hover {
    border-color: rgba(249, 115, 22, 0.3) !important;
  }
  .list-group-item.active {
    background: rgba(59, 130, 246, 0.18) !important;
    color: #ffffff !important;
    border-color: rgba(96, 165, 250, 0.48) !important;
  }

  /* â”€â”€ General dark overrides for Sponzy pages â”€â”€ */
  .section, .section-sm { background: transparent; }
  .jumbotron { background: transparent; }
  .shadow-custom {
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.22) !important;
  }
  .link-scroll { background: rgba(15, 23, 42, 0.92) !important; }

  /* â”€â”€ Form controls dark theme â”€â”€ */
  .form-control,
  .form-select,
  select,
  input[type="text"],
  input[type="email"],
  input[type="password"],
  input[type="number"],
  input[type="date"],
  textarea {
    background: rgba(15, 23, 42, 0.6) !important;
    border: 1px solid rgba(148, 163, 184, 0.18) !important;
    color: #e2e8f0 !important;
  }
  .form-control:focus,
  .form-select:focus,
  input:focus,
  textarea:focus {
    border-color: #f97316 !important;
    box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.15) !important;
  }
  .form-control::placeholder,
  input::placeholder,
  textarea::placeholder {
    color: #64748b !important;
  }
  .form-label,
  label {
    color: #e2e8f0 !important;
  }
  .input-group-text {
    background: rgba(15, 23, 42, 0.8) !important;
    border: 1px solid rgba(148, 163, 184, 0.18) !important;
    color: #94a3b8 !important;
  }

  /* â”€â”€ Buttons â”€â”€ */
  .btn-primary,
  .btn-success {
    background: linear-gradient(135deg, #f97316, #9333ea) !important;
    border: none !important;
    color: #fff !important;
    font-weight: 700 !important;
  }
  .btn-primary:hover,
  .btn-success:hover {
    filter: brightness(1.1);
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
  }
  .btn-danger { color: #fff !important; }

  /* â”€â”€ Tables dark theme â”€â”€ */
  .table {
    color: #e2e8f0 !important;
  }
  .table thead th {
    border-color: rgba(148, 163, 184, 0.12) !important;
    color: #94a3b8 !important;
  }
  .table td {
    border-color: rgba(148, 163, 184, 0.08) !important;
  }

  /* â”€â”€ Messages page layout fix â”€â”€ */
  .section-msg {
    width: 100vw !important;
    max-width: 100vw !important;
    height: 100vh !important;
    height: 100dvh !important;
    padding-top: 0 !important;
    top: 0 !important;
  }
  .section-msg .container {
    height: 100% !important;
  }
  .section-msg .row {
    height: 100% !important;
  }
  .section-msg .card > .content,
  .section-msg #contentDIV {
    flex: 1 1 auto;
    overflow-y: auto;
    min-height: 0;
  }
  .section-msg .card-footer {
    flex-shrink: 0;
    position: relative;
    z-index: 2;
  }
  @@media (min-width: 768px) {
    .section-msg .container {
      max-width: 100% !important;
      width: 100% !important;
    }
    .section-msg .wrapper-msg-inbox {
      order: 0 !important;
    }
    .section-msg .first {
      order: 0 !important;
    }
    .section-msg .col-md-8 {
      position: relative;
      flex: 1 1 0%;
    }
    .section-msg .col-md-8 .card {
      display: flex;
      flex-direction: column;
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      overflow: hidden;
    }
  }

  /* â”€â”€ Links â”€â”€ */
  a.link-border { color: #60a5fa; }
  a.link-border:hover { color: #93c5fd; }

  /* â”€â”€ Video player: poster(1) < logo(2) < video(3) < play-btn(4) < ctrl-bar(5) â”€â”€ */
  .video-js .vjs-logo {
    max-width: 80px !important;
    max-height: 40px !important;
    width: auto !important;
    height: auto !important;
    bottom: 10px !important;
    right: 10px !important;
    left: auto !important;
    top: auto !important;
    opacity: 0.6 !important;
    z-index: 2 !important;
    pointer-events: none !important;
  }
  .video-js .vjs-logo img {
    max-width: 100% !important;
    max-height: 100% !important;
    width: auto !important;
    height: auto !important;
  }
  .video-js .vjs-poster { z-index: 1 !important; }
  .video-js video.vjs-tech { z-index: 3 !important; }
  .video-js .vjs-big-play-button { z-index: 4 !important; }
  .video-js .vjs-control-bar { z-index: 5 !important; }
  .video-js.vjs-fullscreen .vjs-logo,
  .vjs-fullscreen .vjs-logo {
    max-width: 100px !important;
    max-height: 50px !important;
    opacity: 0.4 !important;
  }

  /* â”€â”€ Messaging emoji dropdown fix â”€â”€ */
  .section-msg .dropdown-emoji {
    position: absolute !important;
    bottom: calc(100% + 8px) !important;
    left: 0 !important;
    right: auto !important;
    top: auto !important;
    transform: none !important;
    z-index: 1050 !important;
    max-height: 300px !important;
    overflow-y: auto !important;
    background: #1e293b !important;
    border: 1px solid rgba(148,163,184,.18) !important;
    border-radius: 12px !important;
    box-shadow: 0 16px 50px rgba(0,0,0,.45) !important;
    padding: .5rem !important;
    width: 300px !important;
  }
  .section-msg .dropdown-emoji.show {
    display: block !important;
  }

  /* â”€â”€ Conversation list text contrast â”€â”€ */
  .msg-inbox .text-dark {
    color: #94a3b8 !important;
  }
  .msg-inbox .timeAgo {
    color: #94a3b8 !important;
  }
  .msg-inbox .media-heading {
    color: #e2e8f0 !important;
  }
  .msg-inbox .text-muted {
    color: #94a3b8 !important;
  }

  /* â”€â”€ Message bubbles dark theme â”€â”€ */
  .message.bg-light {
    background: rgba(30, 41, 59, 0.9) !important;
    color: #e2e8f0 !important;
  }
  .container-msg .media-body,
  .container-msg .text-word-break {
    color: #e2e8f0 !important;
  }

  /* â”€â”€ Messages page cards â”€â”€ */
  .section-msg .col-md-8 .card {
    background: rgba(15, 23, 42, 0.95) !important;
    border-left: 1px solid rgba(148, 163, 184, 0.12) !important;
  }
  .section-msg .card-header.bg-white,
  .section-msg .card-footer.bg-white {
    background: rgba(15, 23, 42, 0.95) !important;
    color: #e2e8f0 !important;
  }
  .section-msg .card-header a,
  .section-msg .card-footer a {
    color: #e2e8f0 !important;
  }
  .section-msg .card-header h6 a {
    color: #e2e8f0 !important;
  }

  /* â”€â”€ Posts table dark theme â”€â”€ */
  .table-striped > tbody > tr:nth-of-type(odd) {
    background-color: rgba(30, 41, 59, 0.3) !important;
  }
  .table td, .table th {
    color: #e2e8f0 !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
  }
  .table thead th {
    color: #94a3b8 !important;
    border-bottom-color: rgba(255, 255, 255, 0.15) !important;
  }

  /* â”€â”€ Global mobile section spacing â”€â”€ */
  @@media (max-width: 767.98px) {
    .section, .section-sm { padding: 1.5rem 0 !important; }
    .section-dark { padding: 1.25rem 0 !important; }
    .section-gradient { padding: 2rem 0 !important; }
    .section-photo { padding: 1.5rem 0 !important; }
    .section-dark h2 { margin-bottom: .25rem !important; }
    .section-sub { margin-bottom: 1.5rem !important; }
    .contact-options { gap: .75rem !important; margin-bottom: 1.5rem !important; }
    .support-options { gap: .75rem !important; margin-bottom: 1.5rem !important; }
    .form-card { padding: 1.25rem !important; }
    .contact-section { padding: 2rem 0 !important; }
  }

  /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
     Trix toolbar &#8212; complete dark-theme rebuild
     Overrides core.min.css light-theme defaults.
     Icons: core.min.css provides bold/link/code/number-list;
            remaining 10 are defined here.
     All use black SVGs + filter:invert(1) for the dark theme.
     â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */

  /* â”€â”€ Mobile menu: fix height + remove overlay that blocks taps â”€â”€ */
  @@media (max-width: 991.98px) {
    .navbar-collapse.navbar-mobile.collapse.show {
      height: 100vh !important;
    }
  }
  body.sidebar-overlay #mobileMenuOverlay {
    display: none !important;
  }

  /* â”€â”€ 1. Container: prevent toolbar from forcing parent wider â”€â”€ */
  .media-body:has(trix-toolbar) {
    min-width: 0 !important;
    max-width: 100% !important;
    overflow-x: visible !important;
  }

  /* â”€â”€ 2. Toolbar shell â”€â”€ */
  trix-toolbar {
    display: block !important;
    position: relative !important;
    max-width: 100% !important;
    overflow: hidden !important;
    contain: paint !important;
  }

  /* â”€â”€ 3. Button row: single line, even spacing â”€â”€ */
  trix-toolbar .trix-button-row {
    display: flex !important;
    flex-wrap: nowrap !important;
    justify-content: flex-start !important;
    min-width: 0 !important;
    max-width: 100% !important;
    width: 100% !important;
    overflow: hidden !important;
    gap: 6px !important;
    float: none !important;
  }
  trix-toolbar .trix-button {
    float: none !important;
  }
  /* Mobile: allow horizontal scroll for larger tap targets */
  @@media (max-width: 1024.98px) {
    trix-toolbar {
      overflow: visible !important;
    }
    trix-toolbar .trix-button-row {
      overflow-x: auto !important;
      overflow-y: hidden !important;
      -webkit-overflow-scrolling: touch !important;
      scrollbar-width: none !important;
    }
    trix-toolbar .trix-button-row::-webkit-scrollbar { display: none !important; }
  }

  /* â”€â”€ 4. Button groups â”€â”€ */
  trix-toolbar .trix-button-group {
    flex-shrink: 0 !important;
    min-width: 0 !important;
    border: none !important;
    box-shadow: inset 0 0 0 1px rgba(148,163,184,.18) !important;
    border-radius: 6px !important;
    overflow: hidden !important;
    margin: 0 !important;
  }
  trix-toolbar .trix-button-group-spacer {
    display: none !important;
  }

  /* â”€â”€ 5. Individual buttons: dark theme â”€â”€ */
  trix-toolbar .trix-button {
    flex-shrink: 0 !important;
    color: rgba(229,231,235,.7) !important;
    background: transparent !important;
    border-color: rgba(148,163,184,.12) !important;
    transition: background .15s, color .15s !important;
  }
  trix-toolbar .trix-button--icon {
    max-width: none !important;
    text-indent: -9999px !important;
  }

  /* â”€â”€ 5b. Responsive button widths â”€â”€ */
  /* Desktop (â‰¥1025px): all 14 fit without scroll */
  trix-toolbar .trix-button--icon {
    width: 30px !important;
  }
  trix-toolbar .trix-button {
    padding: 0 5px !important;
  }
  /* Mobile/tablet (â‰¤1024px): larger buttons, scroll to reach all */
  @@media (max-width: 1024.98px) {
    trix-toolbar .trix-button--icon {
      width: 36px !important;
    }
    trix-toolbar .trix-button {
      padding: 0 4px !important;
      font-size: 14px !important;
    }
  }
  trix-toolbar .trix-button:hover {
    background: rgba(148,163,184,.12) !important;
    color: #e5e7eb !important;
  }
  trix-toolbar .trix-button.trix-active {
    background: rgba(249,115,22,.18) !important;
    color: #f97316 !important;
  }
  trix-toolbar .trix-button:disabled {
    color: rgba(148,163,184,.25) !important;
  }

  /* â”€â”€ 6. Icon base: invert black SVGs → white â”€â”€ */
  trix-toolbar .trix-button--icon::before {
    filter: invert(1) !important;
    opacity: .85 !important;
  }
  trix-toolbar .trix-button--icon.trix-active::before {
    filter: invert(1) !important;
    opacity: 1 !important;
  }
  trix-toolbar .trix-button--icon:disabled::before {
    filter: invert(1) !important;
    opacity: .25 !important;
  }

  /* â”€â”€ 7. Icons missing from core.min.css â”€â”€ */
  trix-toolbar .trix-button--icon-italic::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M10 4h4l-1 16h-4l1-16z' fill='%23000'/%3E%3C/svg%3E") !important;
  }
  trix-toolbar .trix-button--icon-strike::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M3 12h18M10 4h4l-1 16h-4l1-16z' stroke='%23000' stroke-width='2'/%3E%3C/svg%3E") !important;
  }
  trix-toolbar .trix-button--icon-heading-1::before {
    content: "H1" !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    color: rgba(229,231,235,.85) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background: none !important;
    background-image: none !important;
    text-indent: 0 !important;
    filter: none !important;
  }
  trix-toolbar .trix-button--icon-quote::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4 10h4v8H4v-8zm10 0h4v8h-4v-8z' fill='%23000'/%3E%3C/svg%3E") !important;
  }
  trix-toolbar .trix-button--icon-bullet-list::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='4' cy='6' r='2' fill='%23000'/%3E%3Ccircle cx='4' cy='12' r='2' fill='%23000'/%3E%3Ccircle cx='4' cy='18' r='2' fill='%23000'/%3E%3Cpath d='M9 6h11M9 12h11M9 18h11' stroke='%23000' stroke-width='2'/%3E%3C/svg%3E") !important;
  }
  trix-toolbar .trix-button--icon-increase-nesting-level::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4 6h16M8 12h12M12 18h8' stroke='%23000' stroke-width='2'/%3E%3C/svg%3E") !important;
  }
  trix-toolbar .trix-button--icon-decrease-nesting-level::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4 6h16M4 12h12M4 18h8' stroke='%23000' stroke-width='2'/%3E%3C/svg%3E") !important;
  }
  trix-toolbar .trix-button--icon-attach::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48' stroke='%23000' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E") !important;
  }
  trix-toolbar .trix-button--icon-undo::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M3 10h10a5 5 0 010 10H3' stroke='%23000' stroke-width='2' stroke-linecap='round'/%3E%3Cpath d='M7 6L3 10l4 4' stroke='%23000' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E") !important;
  }
  trix-toolbar .trix-button--icon-redo::before {
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M21 10H11a5 5 0 000 10h10' stroke='%23000' stroke-width='2' stroke-linecap='round'/%3E%3Cpath d='M17 6l4 4-4 4' stroke='%23000' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E") !important;
  }

  /* â”€â”€ 8. Link dialog: fixed position to escape toolbar overflow â”€â”€ */
  trix-toolbar .trix-dialog {
    position: fixed !important;
    z-index: 100 !important;
    max-width: 400px !important;
    min-width: 280px !important;
    background: #1e293b !important;
    border: 1px solid rgba(148,163,184,.18) !important;
    border-radius: 10px !important;
    box-shadow: 0 8px 30px rgba(0,0,0,.4) !important;
    padding: 12px !important;
  }
  trix-toolbar .trix-dialog input,
  trix-toolbar .trix-input--dialog {
    background: rgba(15,23,42,.8) !important;
    color: #e2e8f0 !important;
    border: 1px solid rgba(148,163,184,.18) !important;
    border-radius: 6px !important;
    padding: 8px 10px !important;
    font-size: .875rem !important;
  }
  trix-toolbar .trix-dialog button,
  trix-toolbar .trix-button--dialog {
    background: linear-gradient(135deg, #f97316, #a855f7) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 6px !important;
    padding: 8px 16px !important;
    font-weight: 600 !important;
    font-size: .875rem !important;
  }

  /* â”€â”€ 9. Mobile: dialog fills bottom â”€â”€ */
  @@media (max-width: 767.98px) {
    trix-toolbar .trix-dialog {
      position: fixed !important;
      top: auto !important;
      bottom: 0 !important;
      left: 0 !important;
      right: 0 !important;
      max-width: 100% !important;
      border-radius: 14px 14px 0 0 !important;
      padding: 16px !important;
    }
  }

  /* â”€â”€ Post creation toolbar mobile fix â”€â”€ */
  @@media (max-width: 767.98px) {
    /* Bottom icon row (image, tag, price, lock, live, Aa) */
    .card-footer .btn-upload,
    .card-footer .btn-tooltip-form {
      padding: .5rem .65rem !important;
      min-width: 44px !important;
      min-height: 44px !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      flex-shrink: 0;
    }
    .card-footer .f-size-25 {
      font-size: 20px !important;
    }
    .card-footer > .justify-content-between {
      display: flex !important;
      flex-wrap: wrap !important;
      gap: .5rem !important;
    }
    .card-footer > .justify-content-between > div {
      display: flex !important;
      flex-wrap: wrap !important;
      gap: .35rem !important;
      align-items: center !important;
      width: 100% !important;
    }
    .card-footer .w-100-mobile {
      width: 100% !important;
      margin-top: .5rem;
    }
    .card-footer #the-count {
      float: none !important;
      margin: .5rem 0 !important;
      width: 100% !important;
    }
    /* Reposition stray elements on mobile to prevent overlap */
    .Category-onder.position-absolute { position: relative !important; top: auto !important; right: auto !important; display: inline-block; }
    .dropdown-cat.position-absolute { position: relative !important; top: auto !important; right: auto !important; }
    .tag_cat_post { display: none !important; }
    .triggerEmoji { position: static !important; right: auto !important; top: auto !important; }
  }
</style>
    <style>
    :root {
      color-scheme: dark;
      --home-text: #e5e7eb;
      --home-muted: #94a3b8;
      --home-line: rgba(255, 255, 255, 0.08);
      --home-panel: #151b2c;
      --home-bg: #0b0f1a;
      --home-gradient: linear-gradient(135deg, #f97316 0%, #a855f7 100%);
    }

    /* ===== HERO ===== */
    .home-hero {
      position: relative;
      overflow: hidden;
      background:
        linear-gradient(rgba(0,0,0,.45), rgba(15,23,42,.35)),
        url("{{ asset('img/ffmherobackground.jpg') }}") center/cover no-repeat;
      color: var(--home-text);
      min-height: calc(100svh + 76px);
      display: flex;
      align-items: center;
      margin-top: -76px;
      /* Equal vertical padding — flex center stays balanced under sticky nav */
      padding: 76px 0 76px;
    }
    .home-hero .hero-grid {
      position: relative;
      z-index: 1;
      display: grid;
      grid-template-columns: minmax(0, 1.08fr) minmax(320px, .92fr);
      gap: 1.5rem;
      align-items: center;
      padding: 2.5rem 0 2.5rem;
      max-width: 72rem;
      margin: 0 auto;
      text-align: left;
    }
    .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: .45rem;
      color: #fb923c;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 0.75rem;
      text-shadow: 0 1px 4px rgba(0,0,0,.6);
    }
    .home-hero h1 {
      font-size: clamp(1.5rem, 3.5vw, 2.25rem);
      line-height: 1.25;
      margin: 0 0 .5rem;
      letter-spacing: -.025em;
      max-width: 32ch;
      color: #fff;
      font-weight: 900;
    }
    .home-hero p {
      color: #f1f5f9;
      max-width: 32rem;
      font-size: 0.875rem;
      font-weight: 500;
      text-shadow: 0 1px 3px rgba(0,0,0,.5);
      line-height: 1.75;
    }

    /* ===== BUTTONS ===== */
    .home-cta {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
      margin-top: 1rem;
    }
    .home-cta .btn {
      border-radius: 12px;
      font-weight: 700;
      min-height: 44px;
      padding: .75rem 1.5rem;
      letter-spacing: -0.01em;
      border-width: 1px;
      font-size: 0.875rem;
      transition: all .3s ease;
    }
    .home-cta .btn-light {
      background: var(--home-gradient) !important;
      background-image: var(--home-gradient) !important;
      border-color: transparent !important;
      color: #fff !important;
      box-shadow: 0 10px 20px rgba(249, 115, 22, .3);
    }
    .home-cta .btn-light:hover {
      transform: scale(1.05);
      box-shadow: 0 14px 28px rgba(249,115,22,.4);
    }
    .home-cta .btn-outline-light {
      background: rgba(30,41,59,.8) !important;
      background-image: none !important;
      border: 1px solid rgba(255,255,255,.15) !important;
      color: #e2e8f0 !important;
      box-shadow: none !important;
    }
    .home-cta .btn-outline-light:hover {
      background: rgba(51,65,85,.8) !important;
      border-color: rgba(255,255,255,.3) !important;
      transform: scale(1.05);
    }

    /* ===== WATERMARK LOGO ===== */
    .home-hero__image {
      width: 75%;
      max-width: 400px;
      margin: 2rem 0 0;
      align-self: end;
      justify-self: center;
      opacity: .95;
    }
    .home-hero__image img {
      display: block;
      width: 100%;
      height: auto;
      filter: drop-shadow(0 20px 40px rgba(0,0,0,.3));
      animation: heroFloat 6s ease-in-out infinite;
    }
    @@keyframes  heroFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    /* ===== SECTION 2: FEATURE CARDS ===== */
    .section-dark { padding: 3rem 0; background: transparent; }
    .section-dark h2 { font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 900; color: #fff; text-align: center; margin-bottom: .5rem; line-height: 1.25; }
    .section-sub { text-align: center; color: #d1d5db; max-width: 48rem; margin: 0 auto 2rem; font-size: .95rem; line-height: 1.75; }

    .grid-4 { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1rem; }
    .card {
      background: rgba(255,255,255,.05);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.1);
      border-radius: 16px;
      padding: 1.5rem;
      height: 100%;
      transition: all .3s ease;
    }
    .card:hover {
      border-color: rgba(249,115,22,.5);
      transform: scale(1.05) translateY(-3px);
      box-shadow: 0 20px 40px rgba(249,115,22,.15);
    }
    .feature-icon {
      width: 56px;
      height: 56px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      background: var(--home-gradient);
      color: #fff;
      font-size: 1.25rem;
      transition: transform .3s ease;
    }
    .feature-icon svg.lucide {
      width: 1.25rem;
      height: 1.25rem;
    }
    .card:hover .feature-icon { transform: scale(1.1); }
    .card h3 { margin: 0 0 .4rem; font-size: 1rem; font-weight: 700; color: #fff; }
    .card p { color: #d1d5db; line-height: 1.65; margin-bottom: 0; font-size: .9rem; }

    /* ===== SECTION 3: FOR FANS ===== */
    .fans-container {
      background: rgba(255,255,255,.05);
      backdrop-filter: blur(8px);
      border-radius: 16px;
      padding: 1.25rem;
      border: 1px solid rgba(255,255,255,.1);
    }
    .fans-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 1rem;
    }
    .fan-card {
      background: linear-gradient(135deg, rgba(249,115,22,.2), rgba(168,85,247,.2));
      border-radius: 12px;
      padding: 1rem;
      text-align: center;
      border: 1px solid rgba(249,115,22,.3);
      transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    .fan-card:nth-child(even) { border-color: rgba(168,85,247,.3); }
    .fan-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 28px rgba(0,0,0,.3);
      border-color: transparent;
      background:
        linear-gradient(#0f172a, #0f172a) padding-box,
        linear-gradient(135deg, rgba(249,115,22,.6), rgba(168,85,247,.6)) border-box;
      border: 1px solid transparent;
    }
    .fan-card i, .fan-card svg.lucide { width: 1.5rem; height: 1.5rem; margin-bottom: .5rem; display: block; }
    .fan-card:nth-child(odd) i, .fan-card:nth-child(odd) svg.lucide { color: #fb923c; }
    .fan-card:nth-child(even) i, .fan-card:nth-child(even) svg.lucide { color: #a78bfa; }
    .fan-card h4 { font-weight: 700; color: #fff; font-size: .95rem; margin-bottom: .25rem; }
    .fan-card p { color: #d1d5db; font-size: .85rem; margin: 0; }

    /* ===== AMBIENT GLOW BLOBS ===== */
    .fans-glow {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      pointer-events: none;
      z-index: 0;
    }
    .fans-glow--orange {
      width: 420px; height: 420px;
      top: -120px; right: -80px;
      background: radial-gradient(circle, rgba(249,115,22,.22), transparent 70%);
    }
    .fans-glow--purple {
      width: 380px; height: 380px;
      bottom: -100px; left: -60px;
      background: radial-gradient(circle, rgba(168,85,247,.20), transparent 70%);
    }
    .fans-glow--pink {
      width: 300px; height: 300px;
      top: 40%; left: 50%;
      transform: translateX(-50%);
      background: radial-gradient(circle, rgba(236,72,153,.10), transparent 70%);
    }
    #fans .container { position: relative; z-index: 1; }

    /* ===== SECTION 4: CTA ===== */
    .section-photo { position: relative; overflow: hidden; background: linear-gradient(rgba(0,0,0,.5), rgba(15,23,42,.5)), url("{{ asset('img/ffmherobackground.jpg') }}") center/cover no-repeat; padding: 3rem 0; text-align: center; }
    .section-photo h2 { font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 900; color: #fff; margin-bottom: .5rem; }
    .section-photo p { color: #d1d5db; font-size: 1rem; max-width: 500px; margin: 0 auto 2rem; line-height: 1.7; }
    .cta-btn { display: inline-flex; align-items: center; gap: .5rem; padding: .75rem 1.75rem; border-radius: 12px; background: var(--home-gradient); color: #fff; font-weight: 700; font-size: 1rem; text-decoration: none; transition: all .3s; box-shadow: 0 14px 28px rgba(249,115,22,.3); }
    .cta-btn:hover { transform: scale(1.05); box-shadow: 0 20px 30px rgba(249,115,22,.4); }

    /* ===== NAV SPACING ===== */
    .public-shell-nav { gap: 0.2rem !important; }

    @@media (max-width: 991.98px) {
      .home-hero { min-height: min(100svh, 760px); padding: 72px 0 72px; }
      .home-hero .hero-grid,
      .fans-grid,
      .grid-4 {
        grid-template-columns: 1fr;
      }
      .public-shell-nav { gap: 0.1rem !important; }
    }
    @@media (max-width: 767.98px) {
      .home-hero {
        display: flex;
        align-items: center;
        min-height: min(92svh, 700px);
        padding: calc(72px + 0.75rem) 0 calc(72px + 0.75rem);
      }
      .home-hero .hero-grid { padding: 1.25rem 0; }
      .home-hero__image { margin-top: 1rem; }
      .section-dark { padding: 1.25rem 0; }
      .section-photo { padding: 1.25rem 0; }
    }
  </style>
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
    }
    a { color: inherit; text-decoration: none; }
    img { max-width: 100%; display: block; }

    .public-shell-topbar {
      position: sticky;
      top: 0;
      z-index: 40;
      background: transparent;
      border-bottom: 1px solid transparent;
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
    .public-shell-content {
      padding: 0;
    }
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

    .public-shell-content .container {
      max-width: 1280px;
    }
    .public-shell-content .card,
    .public-shell-content .panel {
      background: rgba(15,23,42,.84);
      border: 1px solid rgba(148,163,184,.12);
      border-radius: 16px;
      box-shadow: var(--shadow);
      color: #e5e7eb;
    }
    .public-shell-content .btn,
    .public-shell-content .form-control,
    .public-shell-content .custom-select {
      border-radius: 12px;
    }
    .public-shell-content .btn-primary {
      background: #020617;
      border-color: #020617;
      color: #fff;
      box-shadow: 0 10px 24px rgba(2, 6, 23, .22);
    }
    .public-shell-content .btn-primary:hover,
    .public-shell-content .btn-primary:focus {
      background: #111827;
      border-color: #111827;
      color: #fff;
    }
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
    .public-shell-footer .footer-bottom {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: .75rem;
      font-size: .75rem;
      line-height: 1.4;
      color: #9ca3af;
    }
    .public-shell-footer .footer-bottom > * {
      min-width: 0;
    }
    .public-shell-footer .footer-bottom .footer-legal,
    .public-shell-footer .footer-bottom .footer-policies,
    .public-shell-footer .footer-bottom .footer-follow {
      display: inline-flex;
      align-items: center;
      flex-wrap: wrap;
      gap: .5rem;
      margin: 0;
      padding: 0;
      border: 0;
      font-size: inherit;
      line-height: inherit;
      justify-content: flex-start;
    }
    .public-shell-footer .footer-bottom .footer-policies {
      flex-wrap: wrap;
    }
    .public-shell-footer .footer-bottom .footer-policies a {
    }
    .public-shell-footer .footer-bottom .footer-policies span {
      color: #64748b;
    }
    .public-shell-footer .footer-bottom .footer-legal {
      flex-wrap: wrap;
      justify-content: center;
      gap: .5rem .75rem;
    }
    .public-shell-footer .footer-bottom .footer-legal .btc-mark {
      color: #f97316;
      font-weight: 800;
    }
    .public-shell-footer .footer-bottom .footer-legal strong {
      color: #fff;
    }
    .public-shell-footer .footer-bottom .footer-policies {
      margin-top: 0;
    }
    .public-shell-footer .footer-bottom .footer-policies a:hover,
    .public-shell-footer .footer-follow {
      color: var(--text);
    }
    .public-shell-footer .footer-follow-social {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
    }
    .public-shell-footer .footer-follow-text {
      color: #9ca3af;
      font-size: .75rem;
    }
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

    @@media (max-width: 991.98px) {
      .public-shell-topbar .inner {
        min-height: auto;
        flex-wrap: wrap;
        padding: .85rem 0;
      }

      .public-shell-brand {
        flex: 1 1 auto;
      }

      .public-shell-brand img {
        height: 26px;
      }

      .public-shell-actions {
        display: none;
      }

      .public-shell-content .container {
        padding-left: 1rem;
        padding-right: 1rem;
      }

      .public-shell-content {
        padding-bottom: 0 !important;
      }

      .public-shell-footer {
        padding: 2rem 0 1.5rem;
      }

      .public-shell-footer .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 1.1rem;
      }

      .public-shell-footer .footer-bottom {
        align-items: center;
        text-align: center;
      }

    }

    /* Hamburger button */
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
    }

    /* Mobile menu overlay */
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

    .mobile-menu-panel a,
    .mobile-menu-panel button {
      display: flex;
      align-items: center;
      min-height: 44px;
      padding: .75rem 0;
      color: #e5e7eb;
      text-decoration: none;
      font-size: 1.05rem;
      font-weight: 600;
      transition: color .2s;
      background: none;
      border: none;
      text-align: left;
      font-family: inherit;
      cursor: pointer;
      width: 100%;
    }
    .mobile-menu-panel a:hover,
    .mobile-menu-panel button:hover {
      color: #fb923c;
    }
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
  <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="/public/logo-full-lockup.png">
<meta property="og:title" content="FansFollow.me - Global Fitness & Martial Arts Creator Platform">
<meta property="og:description" content="FansFollow.me is the global fitness and martial arts creator platform for subscriptions, coaching, direct fan access, and live creator discovery.">
<meta property="og:image" content="/public/logo-full-lockup.png">
<meta property="og:url" content="https://fansfollowme.com/">
<meta property="og:type" content="website"></head>
<body>
  <header class="public-shell-topbar">
    <div class="container inner">
      <a aria-label='FansFollow.me' class='public-shell-brand' href='/'>
        <img src="/public/logo-monogram.png" alt="FansFollow.me" height="40">
      </a>
      <nav class="public-shell-nav d-none d-lg-flex" aria-label="Primary">
        <a class href='/for-creators'>For Creators</a>
        <a class href='/fans'>For Fans</a>
        <a class href='/celebrities'>Celebrities</a>
        <a class href='/explore'>Explore</a>
        <details class="public-shell-more">
          <summary>More</summary>
          <div class="public-shell-nav-panel">
            <a href='/casting'>&#127912; <span>Movie Casting</span></a>
            <a href='/live-streams'>&#128308; <span>Live Streams</span></a>
            <a href='/business'>&#128188; <span>Business</span></a>
            <a href='/support'>&#128172; <span>Support</span></a>
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

  <!-- Mobile menu overlay -->
  <div class="mobile-menu-overlay" onclick="this.classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')"></div>
  <div class="mobile-menu-panel">
    <div class="mobile-menu-close">
      <button onclick="document.querySelector('.mobile-menu-overlay').classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')" aria-label="Close menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
      </button>
    </div>
    <div class="mobile-menu-section-label">Navigation</div>
    <a href='/for-creators'>For Creators</a>
    <a href='/fans'>For Fans</a>
    <a href='/celebrities'>Celebrities</a>
    <a href='/explore'>Explore</a>
    <div class="mobile-menu-section-label" style="margin-top:.5rem">More</div>
    <a href='/casting'>&#127912; Movie Casting</a>
    <a href='/live-streams'>&#128308; Live Streams</a>
    <a href='/business'>&#128188; Business</a>
    <a href='/support'>&#128172; Support</a>
          <a href='/login' style='margin-top:1rem;color:#94a3b8;font-weight:600'>Login</a>
              <a class='mobile-cta-btn' href='/signup'>Get Started</a>
            </div>

  <main class="public-shell-content">
      <section class="home-hero" id="celebrities">
    <div class="container">
      <div class="hero-grid">
        <div>
          <h1>FansFollow.me &#8212; where fans become friends</h1>
          <div class="hero-eyebrow">For Fitness, Bodybuilding and Martial Arts Creators</div>
          <p>Built for fitness coaches, bodybuilders, nutrition experts, martial artists and combat sports creators to earn from fans worldwide through content, coaching and direct fan access.</p>
          <div class="home-cta">
            <a class='btn btn-light' href='/explore'><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> Explore Creators</a>
            <a class='btn btn-outline-light' href='/signup'><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg> Get Started</a>
          </div>
          <div id="pwa-install" style="display:none;margin-top:1.25rem;">
            <button id="pwa-btn" onclick="installPWA()" style="display:inline-flex;align-items:center;gap:.5rem;padding:.6rem 1.1rem;border-radius:10px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);color:#fff;font-size:.8rem;font-weight:600;cursor:pointer;transition:all .3s;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              <span id="pwa-label">Add to Home Screen</span>
            </button>
            <div id="pwa-ios-hint" style="display:none;margin-top:.5rem;color:#94a3b8;font-size:.75rem;">
              Tap the Share button <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg> then "Add to Home Screen"
            </div>
          </div>
          <script>
          var deferredPrompt;
          var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
          var isAndroid = /Android/.test(navigator.userAgent);
          var isMobile = isIOS || isAndroid;

          window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            deferredPrompt = e;
            document.getElementById('pwa-install').style.display = 'block';
          });

          if (isIOS && !window.navigator.standalone) {
            document.getElementById('pwa-install').style.display = 'block';
            document.getElementById('pwa-ios-hint').style.display = 'block';
            document.getElementById('pwa-btn').style.display = 'none';
          }

          if (window.navigator.standalone) {
            document.getElementById('pwa-install').style.display = 'none';
          }

          function installPWA() {
            if (deferredPrompt) {
              deferredPrompt.prompt();
              deferredPrompt.userChoice.then(function(choice) {
                if (choice.outcome === 'accepted') {
                  document.getElementById('pwa-install').style.display = 'none';
                }
                deferredPrompt = null;
              });
            }
          }
          </script>
        </div>
        <div class="home-hero__image">
          <img src="/public/logo-full-lockup.png" alt="FansFollow.me logo" loading="eager" decoding="async">
        </div>
      </div>
    </div>
  </section>

  <section class="section-dark">
    <div class="container">
      <div class="section-head" style="text-align:center;margin-bottom:2rem;">
        <h2>One home for fitness creators and their fans</h2>
        <p class="section-sub">FansFollow.me brings fighters, coaches, fitness influencers, sports professionals and actors with fitness-based content together on one platform, so fans can find them in one place and creators can build real relationships, add new revenue streams and unlock bigger opportunities.</p>
      </div>
      <div class="grid-4">
        <div class="card"><div class="feature-icon"><i data-lucide="dollar-sign"></i></div><h3>Keep 80%+ Revenue</h3><p>Keep more of what you earn with a creator-first revenue share.</p></div>
        <div class="card"><div class="feature-icon"><i data-lucide="zap"></i></div><h3>17+ Revenue Streams</h3><p>Earn through subscriptions, coaching, premium content, calls, tips and more.</p></div>
        <div class="card"><div class="feature-icon"><i data-lucide="globe"></i></div><h3>Global Payments</h3><p>Accept payments from fans worldwide with flexible payment options.</p></div>
        <div class="card"><div class="feature-icon"><i data-lucide="message-circle"></i></div><h3>Direct Fan Connection</h3><p>Build stronger fan relationships through private access and paid interactions.</p></div>
        <div class="card"><div class="feature-icon"><i data-lucide="camera"></i></div><h3>Mobile Content Creation</h3><p>Create and upload content directly from your phone.</p></div>
        <div class="card"><div class="feature-icon"><i data-lucide="phone"></i></div><h3>Instant Messaging</h3><p>Chat privately with fans in real time.</p></div>
        <div class="card"><div class="feature-icon"><i data-lucide="video"></i></div><h3>Live Streaming</h3><p>Go live to your audience from any device.</p></div>
        <div class="card"><div class="feature-icon"><i data-lucide="qr-code"></i></div><h3>In-Person QR Sign-Ups</h3><p>Let fans join and pay on the spot by scanning your unique QR code at events and gyms.</p></div>
      </div>
    </div>
  </section>

  <section class="section-dark" id="fans" style="background:radial-gradient(ellipse at 80% 20%, rgba(249,115,22,.10), transparent 55%), radial-gradient(ellipse at 15% 85%, rgba(168,85,247,.10), transparent 50%), linear-gradient(160deg, #0b0f1a 0%, #111827 45%, #1a1240 100%);position:relative;overflow:hidden;">
    <div class="fans-glow fans-glow--orange"></div>
    <div class="fans-glow fans-glow--purple"></div>
    <div class="fans-glow fans-glow--pink"></div>
    <div class="container" style="max-width:64rem;">
      <div style="text-align:center;margin-bottom:.75rem;">
        <div style="display:inline-flex;align-items:center;gap:.5rem;padding:.5rem 1rem;border-radius:999px;background:rgba(249,115,22,.2);border:1px solid rgba(249,115,22,.3);margin-bottom:1rem;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fb923c" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <span style="color:#fdba74;font-weight:600;font-size:.75rem;">For Fans Globally | Pay with BTC/ETH/USDT/SOL</span>
        </div>
        <h2>Get closer access to your favourite athletes &amp; creators</h2>
        <p class="section-sub">FansFollow.me lets you build real connections with UFC fighters, bodybuilders, martial artists, fitness models and other creators through private chats, exclusive content, calls and video sessions.</p>
      </div>
      <div class="fans-container">
        <div class="fans-grid">
          <div class="fan-card"><i data-lucide="message-circle"></i><h4>Personal Chats</h4><p>Direct messaging with your favorite athletes</p></div>
          <div class="fan-card"><i data-lucide="lock"></i><h4>Exclusive Content</h4><p>Premium photos, videos, and training materials</p></div>
          <div class="fan-card"><i data-lucide="phone"></i><h4>Phone Calls</h4><p>Voice conversations and coaching</p></div>
          <div class="fan-card"><i data-lucide="video"></i><h4>Video Sessions</h4><p>Face-to-face time with champions and exclusive content</p></div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-photo" id="business">
    <div id="scan" style="position:relative; top:-90px; height:0;"></div>
    <div class="container">
      <h2>Ready to start as a creator?</h2>
      <p>Keep more of what you earn, connect with fans in one place and unlock new media and casting opportunities as you grow on FansFollow.me.</p>
      <a class='cta-btn' href='/signup'>Get Started Now <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
    </div>
  </section>
  </main>

          <footer class="public-shell-footer">
    <div class="container">
      <div class="footer-topline"></div>
      <div class="footer-grid" style="gap: 2rem;">
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">For Creators</h3>
          <a href='/signup' style='font-size: .9rem;'>Getting Started</a>
          <a href='/for-creators' style='font-size: .9rem;'>Personal Video Messages</a>
        </div>
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Revenue Streams</h3>
          <a href='/for-creators' style='font-size: .9rem;'>Content Monetization</a>
          <a href='/for-creators' style='font-size: .9rem;'>Paid Phone Calls</a>
          <a href='/for-creators' style='font-size: .9rem;'>Text Coaching</a>
          <a href='/for-creators' style='font-size: .9rem;'>Video Consultations</a>
        </div>
        <div class="footer-links">
          <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Support</h3>
          <a href='/support' style='font-size: .9rem;'>Help Center</a>
          <a href='/contact' style='font-size: .9rem;'>Contact Us</a>
          <a href='/for-creators' style='font-size: .9rem;'>Creator Resources</a>
          <a href='/contact' style='font-size: .9rem;'>Community</a>
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
      <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: .75rem; padding: .75rem 0;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
          <span style="font-size: .85rem; color: #94a3b8;">© 2026 FansFollow.me. All rights reserved.</span>
          <span style="font-size: .85rem; color: #94a3b8;"><span class="btc-mark">₿</span> <strong>BTC/ETH/USDT/SOL Accepted</strong></span>
          <a href='/privacy' style='font-size: .85rem; color: #94a3b8;'>Privacy Policy</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='/terms' style='font-size: .85rem; color: #94a3b8;'>Terms of Service</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='/cookies' style='font-size: .85rem; color: #94a3b8;'>Cookie Policy</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='/faq' style='font-size: .85rem; color: #94a3b8;'>FAQ</a>
        </div>
        <div style="display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;">
          <span style="font-size: .85rem; color: #94a3b8;">Follow us:</span>
          <div class="footer-social" style="display: flex; gap: .5rem;" aria-label="Social links">
          <a href="https://www.facebook.com/profile.php?id=100089966703593" target="_blank" rel="noopener" aria-label="Facebook" style="color: #94a3b8;"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>          <a href="https://www.instagram.com/fansfollowdotme" target="_blank" rel="noopener" aria-label="Instagram" style="color: #94a3b8;"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.012-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>          <a href="https://www.youtube.com/@FFMFansFollowME" target="_blank" rel="noopener" aria-label="YouTube" style="color: #94a3b8;"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>          <a href="https://www.tiktok.com/@fansfollow.me" target="_blank" rel="noopener" aria-label="TikTok" style="color: #94a3b8;"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.06 6.15-1.62.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.09-.01-8.18.02-12.27z"/></svg></a>          </div>
        </div>
      </div>
    </div>
  </footer>
  
  <script>
	window.paceOptions = {
	    ajax: false,
	    restartOnRequestAfter: false,
	};
</script>
<!--My Changes-->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment.30.1/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lazysizes.3.2/lazysizes.min.js" async=""></script>
<!--My Changes-->
<!--<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>-->
<script type="text/javascript" src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<!--My Changes-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/eonasdan-bootstrap-datetimepicker.17.47/build/js/bootstrap-datetimepicker.min.js"></script>
<!--My Changes-->
  <script src="https://cdn.jsdelivr.net/npm/select2.1.0-rc.0/dist/js/select2.full.min.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2.1.0-rc.0/dist/js/i18n/en.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/medium-editor.23.3/dist/js/medium-editor.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/trix.0.8/dist/trix.umd.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap-tagsinput.8.0/dist/bootstrap-tagsinput.min.js" ></script>
<script>
var URL_BASE = URL_BASE || '';
var logo = '/public/logo-monogram.png';
var limitimage = '/public/logo-monogram.png';
var nuevo_plugin_options = {
		singlePlay:true,
		settingButton: true,
		qualityMenu: true,
        buttonForward: true,
        rewindforward: 10,
        logotitle:'',
        logo: '/public/logo-monogram.png',
		logourl: (typeof URL_BASE !== 'undefined' ? URL_BASE : '') +'/public/logo-monogram.png',
		logoposition: 'RT',
        zoonInfo: true,
    	zoomWheel:false,
    	mirrorButton: true,
    	hdicon: true
        };
</script>
<!--/*My Changes end*/-->
<script type="text/javascript">

</script>

<script type="text/javascript">
/*My changes videosWidth: '100vw'*/
if (typeof $ !== 'undefined') {
$(".js-example-tags").select2({
  placeholder: "Select Or Add Category",
  tags: true
});

$('.poopup-link').click(function(){
    lightbox.open();
})
}
/*My changes end*/

</script>
<!--My Changes-->
<script>
if (typeof $ !== 'undefined') {
$(document).on('click', '.toggle-cat-items', function() {
    $('.cat-nav-list').toggleClass("justify-content-end");
    $('.toggle-cat-items').toggleClass("text-light");
});
}
</script>
<script type="text/javascript">
if (typeof $ !== 'undefined') {

	//<---------------- Login Register ----------->>>>

	_submitEvent = function() {
		  sendFormLoginRegister();
		};

	if (typeof captcha === 'undefined' || captcha == false) {

	    $(document).on('click','#btnLoginRegister',function(s) {

 		 s.preventDefault();
		 sendFormLoginRegister();

 		 });//<<<-------- * END FUNCTION CLICK * ---->>>>
	}

	function sendFormLoginRegister()
	{
		var element = $(this);
		$('#btnLoginRegister').attr({'disabled' : 'true'});
		$('#btnLoginRegister').find('i').addClass('spinner-border spinner-border-sm align-middle mr-1');

		(function(){
			 $("#formLoginRegister").ajaxForm({
			 dataType : 'json',
			 success:  function(result) {

         if (result.actionRequired) {
           $('#modal2fa').modal({
    				    backdrop: 'static',
    				    keyboard: false,
    						show: true
    				});

            $('#loginFormModal').modal('hide');
           return false;
         }

				 // Success
				 if (result.success) {

           if (result.isModal && result.isLoginRegister) {
             window.location.reload();
           }

					 if (result.url_return && ! result.isModal) {
					 	window.location.href = result.url_return;
					 }

					 if (result.check_account) {
					 	$('#checkAccount').html(result.check_account).fadeIn(500);

						$('#btnLoginRegister').removeAttr('disabled');
						$('#btnLoginRegister').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
						$('#errorLogin').fadeOut(100);
						$("#formLoginRegister").reset();
					 }

				 }  else {

					 if (result.errors) {

						 var error = '';
						 var $key = '';

					for ($key in result.errors) {
							 error += '<li><i class="far fa-times-circle"></i> ' + result.errors[$key] + '</li>';
						 }

						 $('#showErrorsLogin').html(error);
						 $('#errorLogin').fadeIn(500);
						 $('#btnLoginRegister').removeAttr('disabled');
						 $('#btnLoginRegister').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
					 }
				 }

				},

				statusCode: {
						419: function() {
							window.location.reload();
						}
					},
				error: function(responseText, statusText, xhr, $form) {
						// error
						$('#btnLoginRegister').removeAttr('disabled');
						$('#btnLoginRegister').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
						swal({
								type: 'error',
								title: error_oops,
								text: error_occurred+' ('+xhr+')',
							});
				}
			}).submit();
		})(); //<--- FUNCTION %
	}// End function sendFormLoginRegister
}
</script>

<!--My Changes-->
<script>
if (typeof $ !== 'undefined') {
$(window).on('load', function(){
    
     $('.lazyloaded').each(function() {
        
        var lazy = $(this);

        var src = lazy.attr('data-src');

        lazy.css('background-image', 'url("'+src+'")');
    
    });
});
}
   /* (function($) {

	$(".cata-sub-nav").on('scroll', function() {
    	$val = $(this).scrollLeft();

    	if($(this).scrollLeft() + $(this).innerWidth()>=$(this)[0].scrollWidth){
          $(".nav-next").hide();
        } else {
    		$(".nav-next").show();
    	}

    	if($val == 0){
    		$(".nav-prev").hide();
    	} else {
    		$(".nav-prev").show();
    	}
  	});
	console.log( 'init-scroll: ' + $(".nav-next").scrollLeft() );
	$(".nav-next").on("click", function(){
		$(".cata-sub-nav").animate( { scrollLeft: '+=460' }, 200);
		
	});
	$(".nav-prev").on("click", function(){
		$(".cata-sub-nav").animate( { scrollLeft: '-=460' }, 200);
	});

	

})(jQuery);*/
</script>
<script>
// Safety: clean up stuck overlay/scroll-lock classes on every page load
document.addEventListener('DOMContentLoaded', function() {
  document.body.classList.remove('sidebar-overlay', 'overflow-hidden', 'stop-scrolling', 'compensate-for-scrollbar');
  document.body.style.overflow = '';
  var overlay = document.getElementById('mobileMenuOverlay');
  if (overlay) overlay.classList.remove('show');
});
</script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
    lucide.createIcons();
    (function() {
      var bar = document.querySelector('.public-shell-topbar');
      if (!bar) return;
      function onScroll() {
        if (window.scrollY > 20) {
          bar.classList.add('scrolled');
        } else {
          bar.classList.remove('scrolled');
        }
      }
      window.addEventListener('scroll', onScroll, {passive: true});
      onScroll();
    })();
  </script>
</body>
</html>
