{{-- PIXEL-EXACT port from signed-off https://fansfollowme.com (celebrities)
     Do NOT restyle. Auth forms/routes only. --}}
<!doctype html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Discover verified celebrity creators on FansFollow.me &#8212; exclusive content from fitness, combat sports and entertainment names fans already follow.">
  <link rel="canonical" href="https://fansfollowme.com/celebrities.html">
    <meta name="keywords" content="donations,support,creators,content creators,subscription,content" />
  <meta name="theme-color" content="#450ea7">
  <meta name="msvalidate.01" content="83E04AABA8CC0BC0618D1849666A133A">
  <title> Celebrities - FansFollow.me</title>
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Creator name in post cards Ã¢â€â‚¬Ã¢â€â‚¬ */
  .card-updates h5 a,
  .card-updates .font-montserrat a {
    color: #f1f5f9 !important;
  }
  .card-updates h5 a:hover,
  .card-updates .font-montserrat a:hover {
    color: #fff !important;
  }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Post image: maintain aspect ratio Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Broken image fallback Ã¢â€â‚¬Ã¢â€â‚¬ */
  .card-updates img,
  .update-media img {
    background: rgba(30, 41, 59, 0.6);
    min-height: 40px;
  }
  .card-updates img:not([src]),
  .card-updates img[src=""] {
    display: none;
  }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Locked post grey bar fix Ã¢â€â‚¬Ã¢â€â‚¬ */
  .content-locked {
    background: rgba(15, 23, 42, 0.82) !important;
    color: #e2e8f0 !important;
  }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Post caption text brightness Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Navbar dark theme Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Left sidebar (menu-left-home) Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Right sidebar: prevent footer from hiding behind fixed bottom nav Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Notification cards dark theme Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ General dark overrides for Sponzy pages Ã¢â€â‚¬Ã¢â€â‚¬ */
  .section, .section-sm { background: transparent; }
  .jumbotron { background: transparent; }
  .shadow-custom {
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.22) !important;
  }
  .link-scroll { background: rgba(15, 23, 42, 0.92) !important; }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Form controls dark theme Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Buttons Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Tables dark theme Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Messages page layout fix Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Links Ã¢â€â‚¬Ã¢â€â‚¬ */
  a.link-border { color: #60a5fa; }
  a.link-border:hover { color: #93c5fd; }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Video player: poster(1) < logo(2) < video(3) < play-btn(4) < ctrl-bar(5) Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Messaging emoji dropdown fix Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Conversation list text contrast Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Message bubbles dark theme Ã¢â€â‚¬Ã¢â€â‚¬ */
  .message.bg-light {
    background: rgba(30, 41, 59, 0.9) !important;
    color: #e2e8f0 !important;
  }
  .container-msg .media-body,
  .container-msg .text-word-break {
    color: #e2e8f0 !important;
  }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Messages page cards Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Posts table dark theme Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Global mobile section spacing Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢Â
     Trix toolbar &#8212; complete dark-theme rebuild
     Overrides core.min.css light-theme defaults.
     Icons: core.min.css provides bold/link/code/number-list;
            remaining 10 are defined here.
     All use black SVGs + filter:invert(1) for the dark theme.
     Ã¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢ÂÃ¢â€¢Â */

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Mobile menu: fix height + remove overlay that blocks taps Ã¢â€â‚¬Ã¢â€â‚¬ */
  @@media (max-width: 991.98px) {
    .navbar-collapse.navbar-mobile.collapse.show {
      height: 100vh !important;
    }
  }
  body.sidebar-overlay #mobileMenuOverlay {
    display: none !important;
  }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 1. Container: prevent toolbar from forcing parent wider Ã¢â€â‚¬Ã¢â€â‚¬ */
  .media-body:has(trix-toolbar) {
    min-width: 0 !important;
    max-width: 100% !important;
    overflow-x: visible !important;
  }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 2. Toolbar shell Ã¢â€â‚¬Ã¢â€â‚¬ */
  trix-toolbar {
    display: block !important;
    position: relative !important;
    max-width: 100% !important;
    overflow: hidden !important;
    contain: paint !important;
  }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 3. Button row: single line, even spacing Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 4. Button groups Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 5. Individual buttons: dark theme Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 5b. Responsive button widths Ã¢â€â‚¬Ã¢â€â‚¬ */
  /* Desktop (Ã¢â€°Â¥1025px): all 14 fit without scroll */
  trix-toolbar .trix-button--icon {
    width: 30px !important;
  }
  trix-toolbar .trix-button {
    padding: 0 5px !important;
  }
  /* Mobile/tablet (Ã¢â€°Â¤1024px): larger buttons, scroll to reach all */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 6. Icon base: invert black SVGs Ã¢â€ â€™ white Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 7. Icons missing from core.min.css Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 8. Link dialog: fixed position to escape toolbar overflow Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ 9. Mobile: dialog fills bottom Ã¢â€â‚¬Ã¢â€â‚¬ */
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

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Post creation toolbar mobile fix Ã¢â€â‚¬Ã¢â€â‚¬ */
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
  :root { color-scheme: dark; --home-gradient: linear-gradient(135deg, #f97316 0%, #a855f7 100%); --gold-gradient: linear-gradient(135deg, #f59e0b, #f97316); }

  .celeb-hero {
    position: relative;
    overflow: hidden;
    background: #0b0f1a;
    margin-top: -72px;
    padding: calc(72px + 6rem) 0 5rem;
    color: #e5e7eb;
  }
  .celeb-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('{{ asset('img/marketing/celebhero.png') }}?v=viking1') center 8%/cover no-repeat;
    z-index: 0;
  }
  .celeb-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(rgba(0,0,0,.55), rgba(15,23,42,.45));
    z-index: 1;
  }
  .celeb-hero > .container { position: relative; z-index: 2; }
  .celeb-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .4rem 1rem;
    border-radius: 999px;
    background: linear-gradient(135deg, rgba(245,158,11,.2), rgba(249,115,22,.2));
    border: 1px solid rgba(245,158,11,.3);
    color: #fbbf24;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 1.5rem;
  }
  .celeb-hero h1 {
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 900;
    margin-bottom: .75rem;
    max-width: 550px;
    text-align: left;
  }
  .celeb-hero h1 .white { color: #fff; }
  .celeb-hero h1 .gold { color: #fbbf24; }
  .celeb-hero p {
    font-size: 1rem;
    color: #e2e8f0;
    max-width: 550px;
    margin: 0 0 2rem;
    line-height: 1.75;
    text-align: left;
    font-weight: 500;
    text-shadow: 0 1px 3px rgba(0,0,0,.5);
  }
  .hero-btns { display: flex; gap: .75rem; flex-wrap: wrap; }

  .cta-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1.75rem;
    border-radius: 12px;
    background: var(--gold-gradient);
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all .3s;
    box-shadow: 0 14px 28px rgba(245,158,11,.3);
  }
  .cta-btn:hover { transform: scale(1.05); box-shadow: 0 20px 30px rgba(245,158,11,.4); }
  .cta-btn-outline {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1.75rem;
    border-radius: 12px;
    background: rgba(30,41,59,.8);
    border: 1px solid rgba(255,255,255,.15);
    color: #e2e8f0;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all .3s;
  }
  .cta-btn-outline:hover { background: rgba(51,65,85,.8); border-color: rgba(255,255,255,.25); }
  .cta-btn-home {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1.75rem;
    border-radius: 12px;
    background: var(--home-gradient);
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all .3s;
    box-shadow: 0 14px 28px rgba(249,115,22,.3);
  }
  .cta-btn-home:hover { transform: scale(1.05); }

  .section-dark { padding: 4rem 0 2rem; background: transparent; }
  .section-dark h2 { font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 900; color: #fff; text-align: center; margin-bottom: .5rem; }
  .section-sub { text-align: center; color: #d1d5db; max-width: 650px; margin: 0 auto 2.5rem; font-size: 1rem; line-height: 1.7; }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Feature cards Ã¢â€â‚¬Ã¢â€â‚¬ */
  .card-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; max-width: 1100px; margin: 0 auto; }
  .card-item {
    background: rgba(255,255,255,.05);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 16px;
    padding: 1.5rem;
    transition: all .3s ease;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,.1), 0 4px 6px -4px rgba(0,0,0,.1);
  }
  .card-item:hover {
    transform: translateY(-4px) scale(1.02);
    border-color: rgba(249,115,22,.4);
    box-shadow: 0 20px 40px rgba(0,0,0,.3), 0 0 20px rgba(249,115,22,.15);
  }
  /* Featured cards &#8212; same size, enhanced glow */
  .card-item.featured {
    background: rgba(255,255,255,.08);
    position: relative;
  }
  .card-item.featured::before {
    content: '';
    position: absolute;
    top: 0;
    left: 1rem;
    right: 1rem;
    height: 3px;
    border-radius: 3px 3px 0 0;
    background: var(--gold-gradient);
  }
  .card-item.featured-gold {
    border-color: rgba(245,158,11,.35);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,.1), 0 4px 6px -4px rgba(0,0,0,.1), 0 0 25px rgba(245,158,11,.1);
  }
  .card-item.featured-gold:hover {
    box-shadow: 0 20px 40px rgba(0,0,0,.3), 0 0 30px rgba(245,158,11,.2);
    border-color: rgba(245,158,11,.5);
  }
  .card-item.featured-teal {
    border-color: rgba(20,184,166,.35);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,.1), 0 4px 6px -4px rgba(0,0,0,.1), 0 0 25px rgba(20,184,166,.1);
  }
  .card-item.featured-teal:hover {
    box-shadow: 0 20px 40px rgba(0,0,0,.3), 0 0 30px rgba(20,184,166,.2);
    border-color: rgba(20,184,166,.5);
  }

  .card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: .75rem;
    color: #fff;
    font-size: 1.25rem;
  }
  .card-icon svg.lucide { width: 1.25rem; height: 1.25rem; }
  .card-item h4 { color: #fff; font-size: 1rem; font-weight: 700; margin-bottom: .3rem; }
  .card-item p { color: #d1d5db; font-size: .85rem; line-height: 1.6; margin: 0; }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Founder cards Ã¢â€â‚¬Ã¢â€â‚¬ */
  .founder-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; max-width: 1100px; margin: 0 auto; }
  .founder-card {
    background: rgba(255,255,255,.05);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all .3s ease;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,.1), 0 4px 6px -4px rgba(0,0,0,.1);
  }
  .founder-card:hover {
    transform: translateY(-4px) scale(1.02);
    border-color: rgba(249,115,22,.4);
    box-shadow: 0 20px 40px rgba(0,0,0,.3), 0 0 20px rgba(249,115,22,.15);
  }
  .founder-card .founder-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: .75rem;
    color: #fff;
    font-size: 1.25rem;
  }
  .founder-icon svg.lucide { width: 1.25rem; height: 1.25rem; }
  .founder-card h4 { color: #fff; font-size: .95rem; font-weight: 700; margin-bottom: .2rem; }
  .founder-card p { color: #d1d5db; font-size: .8rem; margin: 0; }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Badge glow Ã¢â€â‚¬Ã¢â€â‚¬ */
  .badge-glow {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .4rem 1rem;
    border-radius: 999px;
    background: linear-gradient(135deg, rgba(249,115,22,.25), rgba(234,88,12,.25));
    border: 1px solid rgba(249,115,22,.4);
    color: #fb923c;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    box-shadow: 0 0 20px rgba(249,115,22,.2), 0 0 40px rgba(249,115,22,.1);
  }

  /* Ã¢â€â‚¬Ã¢â€â‚¬ Film section Ã¢â€â‚¬Ã¢â€â‚¬ */
  .film-tabs { display: flex; gap: .5rem; justify-content: center; margin-bottom: 2rem; flex-wrap: wrap; }
  .film-tab {
    padding: .6rem 1.25rem;
    border-radius: 12px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.1);
    color: #d1d5db;
    font-weight: 600;
    font-size: .9rem;
    cursor: pointer;
    transition: all .2s;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .film-tab.active, .film-tab:hover {
    background: var(--home-gradient);
    color: #fff;
    border-color: transparent;
  }
  .film-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; max-width: 1100px; margin: 0 auto; }
  .film-card {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 16px;
    overflow: hidden;
    transition: all .3s ease;
  }
  .film-card:hover {
    transform: translateY(-4px);
    border-color: rgba(249,115,22,.4);
    box-shadow: 0 20px 40px rgba(0,0,0,.3), 0 0 20px rgba(249,115,22,.15);
  }
  .film-poster {
    height: 200px;
    background-size: cover;
    background-position: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    color: #475569;
    font-size: 3rem;
  }
  .film-poster .coming-soon { font-size: .85rem; font-weight: 600; color: #64748b; letter-spacing: .05em; }
  .film-info { padding: 1rem; }
  .film-info h4 { color: #fff; font-size: .95rem; font-weight: 700; margin-bottom: .2rem; }
  .film-info .film-year { color: #d1d5db; font-size: .8rem; }
  .film-info .film-role { color: #a78bfa; font-size: .8rem; font-weight: 600; margin-top: .3rem; }
  .film-status { display: inline-block; font-size: .75rem; font-weight: 600; margin-top: .3rem; }
  .status-post { color: #fb923c; }
  .status-pre { color: #a78bfa; }

  .cta-center { text-align: center; margin-top: 2rem; }

  @@media (max-width: 768px) { .card-grid, .founder-grid, .film-grid { grid-template-columns: 1fr; } }
  @@media (max-width: 767.98px) {
    .celeb-hero { padding: calc(72px + 1.5rem) 0 2rem; }
    .section-dark { padding: 2rem 0; }
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
<meta property="og:title" content="Celebrities - FansFollow.me
 FansFollow.me">
<meta property="og:description" content="Discover verified celebrity creators on FansFollow.me &#8212; exclusive content from fitness, combat sports and entertainment names fans already follow.">
<meta property="og:image" content="/public/logo-full-lockup.png">
<meta property="og:url" content="https://fansfollowme.com/celebrities.html">
<meta property="og:type" content="website"></head>
<body>
  <header class="public-shell-topbar">
    <div class="container inner">
      <a aria-label='FansFollow.me' class='public-shell-brand' href='{{ route('home') }}'>
        <img src="/public/logo-monogram.png" alt="FansFollow.me" height="40">
      </a>
      <nav class="public-shell-nav d-none d-lg-flex" aria-label="Primary">
        <a class href='{{ route('page.for-creators') }}'>For Creators</a>
        <a class href='{{ route('page.fans') }}'>For Fans</a>
        <a class=' active ' href='{{ route('page.celebrities') }}'>Celebrities</a>
        <a class href='{{ route('page.explore') }}'>Explore</a>
        <details class="public-shell-more">
          <summary>More</summary>
          <div class="public-shell-nav-panel">
            <a href='{{ route('page.casting') }}'>&#127912; <span>Movie Casting</span></a>
            <a href='{{ route('page.live-streams') }}'>&#128308; <span>Live Streams</span></a>
            <a href='{{ route('page.business') }}'>&#128188; <span>Business</span></a>
            <a href='{{ route('page.contact') }}'>&#128172; <span>Support</span></a>
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
              <button class="public-shell-hamburger onclick="document.querySelector('.mobile-menu-overlay').classList.add('is-open');document.querySelector('.mobile-menu-panel').classList.add('is-open')" aria-label="Open menu">
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
    <a href='{{ route('page.for-creators') }}'>For Creators</a>
    <a href='{{ route('page.fans') }}'>For Fans</a>
    <a href='{{ route('page.celebrities') }}'>Celebrities</a>
    <a href='{{ route('page.explore') }}'>Explore</a>
    <div class="mobile-menu-section-label" style="margin-top:.5rem">More</div>
    <a href='{{ route('page.casting') }}'>&#127912; Movie Casting</a>
    <a href='{{ route('page.live-streams') }}'>&#128308; Live Streams</a>
    <a href='{{ route('page.business') }}'>&#128188; Business</a>
    <a href='{{ route('page.contact') }}'>&#128172; Support</a>
          <a href='{{ route('login') }}' style='margin-top:1rem;color:#94a3b8;font-weight:600'>Login</a>
              <a class='mobile-cta-btn' href='{{ route('register') }}'>Get Started</a>
            </div>

  <main class="public-shell-content">
    <section class="celeb-hero">
  <div class="container">
    <div class="celeb-badge">Ã¢Ëœâ€¦ CELEBRITY CONNECTIONS</div>
    <h1><span class="white">Chat Personally<br>With<br>Your </span><span class="gold">Favorite Champions</span></h1>
    <p>Connect directly with UFC fighters, Olympic champions, bodybuilding legends, and fitness icons. Build real friendships through personal chats, phone calls, and video hangouts.</p>
    <div class="hero-btns">
      <a class='cta-btn' href='{{ route('page.explore') }}'>Explore Celebrities</a>
      <a class='cta-btn-outline' href='{{ route('register') }}'>Become a Fan</a>
    </div>
  </div>
</section>

<section class="section-dark">
  <div class="container">
    <h2>Why Celebrities Choose FansFollow</h2>
    <p class="section-sub">A platform designed for athletes, entertainers and influencers who work with sponsors and mainstream media.</p>
    <div class="card-grid">
      <div class="card-item"><div class="card-icon" style="background:linear-gradient(135deg,#ec4899,#db2777);"><i data-lucide="handshake"></i></div><h4>Real connections</h4><p>Build genuine, positive relationships with fans through fitness, training and combat-sports content in a fully brand-safe environment.</p></div>
      <div class="card-item featured featured-gold"><div class="card-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);"><i data-lucide="gem"></i></div><h4>Premium benefits</h4><p>Keep 80%+ of your earnings with clear reporting, VIP rates for high-volume talent, and terms that work for you and your team.</p></div>
      <div class="card-item"><div class="card-icon" style="background:linear-gradient(135deg,#3b82f6,#2563eb);"><i data-lucide="clock"></i></div><h4>Your schedule, your rules</h4><p>Set your own rates, availability and interaction preferences so every engagement fits your time, boundaries and sponsors.</p></div>
      <div class="card-item featured featured-teal"><div class="card-icon" style="background:linear-gradient(135deg,#14b8a6,#0d9488);"><i data-lucide="shield"></i></div><h4>Brand-safe by design</h4><p>A professional, non-adult platform built for athletes, entertainers and influencers who work with sponsors and mainstream media.</p></div>
      <div class="card-item"><div class="card-icon" style="background:linear-gradient(135deg,#a855f7,#7c3aed);"><i data-lucide="users"></i></div><h4>High-quality audience</h4><p>Reach verified, paying fans who value your work, not bots or low-intent followers.</p></div>
      <div class="card-item"><div class="card-icon" style="background:linear-gradient(135deg,#f97316,#ea580c);"><i data-lucide="star"></i></div><h4>Built with industry experience</h4><p>Created by a founder with multiple film and media credits who understands how to protect long-term reputation and endorsements.</p></div>
    </div>
    <div class="cta-center"><a class='cta-btn-home' href='{{ route('register') }}'>Apply for Celebrity Status <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a></div>
  </div>
</section>

<section class="section-dark" style="border-top: 1px solid rgba(255,255,255,.06);">
  <div class="container">
    <div style="text-align:center;margin-bottom:1rem;"><div class="badge-glow">Ã¢Ëœâ€¦ FFM FOUNDER'S ACCOLADES</div></div>
    <h2>David Kurzhal - The Viking Samurai</h2>
    <p class="section-sub">From martial arts champion to Hollywood action star &#8212; the expertise behind FFM.</p>
    <div class="founder-grid">
      <div class="founder-card"><div class="founder-icon" style="background:linear-gradient(135deg,#f97316,#ea580c);"><i data-lucide="film"></i></div><h4>Lead Actor</h4><p>8+ Feature Films</p></div>
      <div class="founder-card"><div class="founder-icon" style="background:linear-gradient(135deg,#a855f7,#7c3aed);"><i data-lucide="camera"></i></div><h4>Martial Arts Expert</h4><p>5th Dan Black Belt, Viking Samurai</p></div>
      <div class="founder-card"><div class="founder-icon" style="background:linear-gradient(135deg,#f97316,#a855f7);"><i data-lucide="zap"></i></div><h4>Stunt Performer</h4><p>Action Choreographer</p></div>
      <div class="founder-card"><div class="founder-icon" style="background:linear-gradient(135deg,#a855f7,#ec4899);"><i data-lucide="video"></i></div><h4>YouTuber</h4><p>Channel Dedicated to 80s & 90s Martial Arts Cinema</p></div>
      <div class="founder-card"><div class="founder-icon" style="background:linear-gradient(135deg,#ec4899,#f97316);"><i data-lucide="users"></i></div><h4>Celebrity Boxer</h4><p>In talks with various big names</p></div>
      <div class="founder-card"><div class="founder-icon" style="background:linear-gradient(135deg,#f97316,#ec4899);"><i data-lucide="heart"></i></div><h4>Interviewed Legends</h4><p>Steven Seagal, Scott Adkins, Don Wilson, Michael Jai White, Michel Qissi</p></div>
    </div>
  </div>
</section>

<section class="section-dark" style="border-top: 1px solid rgba(255,255,255,.06);">
  <div class="container">
    <div style="text-align:center;margin-bottom:1rem;"><div class="badge-glow">Ã¢Ëœâ€¦ NOW SHOWING: FFM FOUNDER'S FEATURED FILMS</div></div>
    <h2>From Martial Arts Champion to Hollywood Action Star</h2>
    <p class="section-sub" style="max-width:700px;">David Kurzhal's complete filmography - from released blockbusters to upcoming projects. Now we're creating opportunities for FFM creators to star in martial arts films.</p>
    <div class="film-tabs">
      <div class="film-tab active" onclick="showTab('released')">Released</div>
      <div class="film-tab" onclick="showTab('post')">In Post-Production</div>
      <div class="film-tab" onclick="showTab('pre')">In Pre-Production / Upcoming</div>
    </div>
    <div id="tab-released" class="film-grid">
      <div class="film-card"><div class="film-poster" style="background-image:url('{{ asset('img/marketing/lastkumite.jpeg') }}?v=film2');"></div><div class="film-info"><h4>The Last Kumite</h4><div class="film-year">2024</div><div class="film-role">Role: Marcus Gantz</div></div></div>
      <div class="film-card"><div class="film-poster" style="background-image:url('{{ asset('img/marketing/bloodstorm.jpeg') }}?v=film2');"></div><div class="film-info"><h4>Bloodstorm</h4><div class="film-year">2025</div><div class="film-role">Role: Bennet (Lead Role)</div></div></div>
      <div class="film-card"><div class="film-poster" style="background-image:url('{{ asset('img/marketing/elitetarget.png') }}?v=film2');"></div><div class="film-info"><h4>Elite Target</h4><div class="film-year">2025</div><div class="film-role">Role: Alpha Commando</div></div></div>
    </div>
    <div id="tab-post" class="film-grid" style="display:none;">
      <div class="film-card"><div class="film-poster" style="background-image:url('{{ asset('img/marketing/Order_of_the_dragon.png') }}?v=film2');"></div><div class="film-info"><h4>Order of the Dragon</h4><div class="film-role">Role: Jean Pierre (Co-starring Steven Seagal)</div><div class="film-status status-post">In Post-Production</div></div></div>
      <div class="film-card"><div class="film-poster" style="background-image:url('{{ asset('img/marketing/Hard_redemption.png') }}?v=film2');"></div><div class="film-info"><h4>Hard Redemption</h4><div class="film-role">Role: Solomon</div><div class="film-status status-post">In Post-Production</div></div></div>
      <div class="film-card"><div class="film-poster" style="background-image:url('{{ asset('img/marketing/Warrior_island.png') }}?v=film2');"></div><div class="film-info"><h4>Warrior Island</h4><div class="film-role">Role: Viking Samurai</div><div class="film-status status-post">In Post-Production</div></div></div>
    </div>
    <div id="tab-pre" class="film-grid" style="display:none;">
      <div class="film-card"><div class="film-poster"><i data-lucide="film"></i><span class="coming-soon">COMING SOON</span></div><div class="film-info"><h4>Guardian Peacemaker</h4><div class="film-role">Main Actor: David Kurzhal, Main Actress: Shaina West</div><div class="film-status status-pre">In Pre-Production</div></div></div>
      <div class="film-card"><div class="film-poster" style="background-image:url('{{ asset('img/marketing/Warrior_island_darker_days.png') }}?v=film2');"></div><div class="film-info"><h4>Warrior Island: Darker Days</h4><div class="film-role">Role: Viking Samurai</div><div class="film-status status-pre">In Pre-Production</div></div></div>
      <div class="film-card"><div class="film-poster" style="background-image:url('{{ asset('img/marketing/magnetic_fighters.png') }}?v=film2');"></div><div class="film-info"><h4>The Magnetic Fighters</h4><div class="film-year">2026</div><div class="film-role">Role: Samurai Hayate</div><div class="film-status status-pre">Upcoming</div></div></div>
    </div>
  </div>
</section>

<script>
function showTab(tab) {
  document.querySelectorAll('.film-grid').forEach(g => g.style.display = 'none');
  document.querySelectorAll('.film-tab').forEach(t => t.classList.remove('active'));
  document.getElementById('tab-' + tab).style.display = 'grid';
  event.target.classList.add('active');
}
</script>
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
          <a href='{{ route('page.contact') }}' style='font-size: .9rem;'>Help Center</a>
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
      <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: .75rem; padding: .75rem 0;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
          <span style="font-size: .85rem; color: #94a3b8;">Ã‚Â© 2026 FansFollow.me. All rights reserved.</span>
          <span style="font-size: .85rem; color: #94a3b8;"><span class="btc-mark">Ã¢â€šÂ¿</span> <strong>BTC/ETH/USDT/SOL Accepted</strong></span>
          <a href='{{ route('page.privacy') }}' style='font-size: .85rem; color: #94a3b8;'>Privacy Policy</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='{{ route('page.terms') }}' style='font-size: .85rem; color: #94a3b8;'>Terms of Service</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='{{ route('page.cookies') }}' style='font-size: .85rem; color: #94a3b8;'>Cookie Policy</a>
          <span style="color: #4b5563;">&#8226;</span>
          <a href='{{ route('page.faq') }}' style='font-size: .85rem; color: #94a3b8;'>FAQ</a>
        </div>
        <div style="display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;">
          <span style="font-size: .85rem; color: #94a3b8;">Follow us:</span>
          <div class="footer-social" style="display: flex; gap: .5rem;" aria-label="Social links">
          <a href="https://www.facebook.com/profile.php?id=100089966703593" target="_blank" rel="noopener" aria-label="Facebook" style="color: #94a3b8;"><i class="fab fa-facebook-f"></i></a>          <a href="https://www.instagram.com/fansfollowdotme" target="_blank" rel="noopener" aria-label="Instagram" style="color: #94a3b8;"><i class="fab fa-instagram"></i></a>          <a href="https://www.youtube.com/@FFMFansFollowME" target="_blank" rel="noopener" aria-label="YouTube" style="color: #94a3b8;"><i class="fab fa-youtube"></i></a>          <a href="https://www.tiktok.com/@fansfollow.me" target="_blank" rel="noopener" aria-label="TikTok" style="color: #94a3b8;"><i class="fab fa-tiktok"></i></a>          </div>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment.30.1/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lazysizes.3.2/lazysizes.min.js" async=""></script>
<script type="text/javascript" src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/eonasdan-bootstrap-datetimepicker.17.47/build/js/bootstrap-datetimepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2.1.0-rc.0/dist/js/select2.full.min.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2.1.0-rc.0/dist/js/i18n/en.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/medium-editor.23.3/dist/js/medium-editor.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/trix.0.8/dist/trix.umd.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap-tagsinput.8.0/dist/bootstrap-tagsinput.min.js" ></script>
<script>
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

<script>
if (typeof $ !== 'undefined') {
$(document).on('click', '.toggle-cat-items', function() {
    $('.cat-nav-list').toggleClass("justify-content-end");
    $('.toggle-cat-items').toggleClass("text-light");
});
}
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
