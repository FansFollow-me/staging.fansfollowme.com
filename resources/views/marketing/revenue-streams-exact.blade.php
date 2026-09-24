<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Creator revenue streams on FansFollow.me — keep 80%+ of earnings across subscriptions, tips, PPV, shop, video messages and more.">
  <meta name="theme-color" content="#f97316">
  <title>Revenue Streams - FansFollow.me</title>
  <link href="data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 64 64%27%3E%3Crect width=%2764%27 height=%2764%27 rx=%2712%27 fill=%27%230d1119%27/%3E%3Ctext x=%2732%27 y=%2744%27 font-size=%2736%27 font-weight=%27bold%27 text-anchor=%27middle%27 fill=%27%23f97316%27 font-family=%27Arial,sans-serif%27%3EF%3C/text%3E%3C/svg%3E" rel="icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/ffm-mobile-spacing.css') }}?v=ffm5" rel="stylesheet">
  <style>
    :root {
      color-scheme: dark;
      --bg: #0B0F1A;
      --panel: #151b2c;
      --line: rgba(255,255,255,.08);
      --text: #e5e7eb;
      --muted: #94a3b8;
      --gradient: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      background: var(--bg);
      color: var(--text);
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
    }
    a { color: inherit; text-decoration: none; }

    .public-shell-topbar {
      position: sticky; top: 0; z-index: 40;
      background: rgba(11,15,26,.88);
      backdrop-filter: blur(18px);
    }
    .public-shell-topbar .inner {
      min-height: 64px;
      display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    }
    .public-shell-brand img { height: 48px; width: auto; }
    .public-shell-nav { display: flex; gap: .15rem; flex-wrap: wrap; }
    .public-shell-nav a {
      padding: .5rem .7rem; border-radius: 10px; font-weight: 700; font-size: .9rem; color: #cbd5e1;
    }
    .public-shell-nav a:hover, .public-shell-nav a.active { color: #fb923c; }
    .public-shell-button {
      border-radius: 12px; font-weight: 700; min-height: 44px; padding: .65rem 1.1rem;
      display: inline-flex; align-items: center;
    }
    .public-shell-button.btn-primary {
      background: var(--gradient); color: #fff; border: none;
      box-shadow: 0 10px 20px rgba(249,115,22,.3);
    }
    .public-shell-hamburger { display: none; }

    .page-hero {
      padding: 3rem 0 2rem;
    }
    .page-hero h1 {
      font-size: clamp(2rem, 3.5vw, 3rem);
      font-weight: 900;
      letter-spacing: -0.02em;
      color: #fff;
      margin: 0 0 .75rem;
    }
    .page-hero p {
      color: var(--muted);
      max-width: 40rem;
      line-height: 1.7;
      font-weight: 500;
    }
    .share-banner {
      display: flex; flex-wrap: wrap; align-items: center; gap: 1rem;
      margin: 1.5rem 0 2rem;
      padding: 1.25rem 1.5rem;
      border-radius: 16px;
      background: linear-gradient(135deg, rgba(249,115,22,.18), rgba(147,51,234,.18));
      border: 1px solid rgba(249,115,22,.35);
    }
    .share-banner .big {
      font-size: clamp(1.75rem, 4vw, 2.5rem);
      font-weight: 900;
      background: var(--gradient);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .stream-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 1rem;
      margin-bottom: 2.5rem;
    }
    .stream-card {
      background: var(--panel);
      border: 1px solid var(--line);
      border-radius: 16px;
      padding: 1.25rem;
      box-shadow: 0 12px 36px rgba(0,0,0,.22);
    }
    .stream-card h3 {
      margin: 0 0 .4rem;
      font-size: 1rem;
      font-weight: 800;
      color: #fff;
    }
    .stream-card p {
      margin: 0;
      color: var(--muted);
      font-size: .88rem;
      line-height: 1.5;
    }
    .stream-icon {
      width: 44px; height: 44px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: .85rem; color: #fff; font-size: 1.1rem;
    }
    .cta-row { display: flex; flex-wrap: wrap; gap: .75rem; margin-bottom: 2.5rem; }
    .cta-btn {
      display: inline-flex; align-items: center; gap: .5rem;
      padding: .85rem 1.5rem; border-radius: 12px;
      background: var(--gradient); color: #fff; font-weight: 800;
      box-shadow: 0 10px 24px rgba(249,115,22,.28);
    }
    .cta-btn-outline {
      display: inline-flex; align-items: center; gap: .5rem;
      padding: .85rem 1.5rem; border-radius: 12px;
      background: rgba(30,41,59,.8); border: 1px solid rgba(255,255,255,.15);
      color: #e2e8f0; font-weight: 700;
    }

    .public-shell-footer {
      padding: 1.5rem 0 1.2rem;
      background: linear-gradient(135deg, #111827, #1f2937, #111827);
      border-top: 1px solid #1f293b;
      color: var(--muted);
      margin-top: 2rem;
    }
    .public-shell-footer .footer-topline,
    .public-shell-footer .footer-bottomline {
      height: 3px; border-radius: 999px;
      background: linear-gradient(90deg, rgba(249,115,22,0), rgba(249,115,22,.85), rgba(168,85,247,.95), rgba(236,72,153,0));
    }
    .public-shell-footer .footer-topline { margin-bottom: 1rem; }
    .public-shell-footer .footer-bottomline { margin: 1.5rem 0 .75rem; }
    .footer-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
    .footer-links h3 {
      margin: 0 0 .75rem; font-size: .875rem; font-weight: 700; color: #fff;
    }
    .footer-links a, .footer-links span {
      display: block; padding: .35rem 0; color: #9ca3af; font-size: .75rem;
    }
    .footer-links a:hover { color: #fff; }
    .footer-bottom {
      display: flex; flex-wrap: wrap; justify-content: space-between; gap: .75rem;
      font-size: .78rem;
    }
    .footer-social { display: flex; gap: .5rem; }
    .footer-social a {
      width: 40px; height: 40px; border-radius: 50%;
      display: inline-flex; align-items: center; justify-content: center;
      background: #1f2937; color: #9ca3af; border: 1px solid rgba(255,255,255,.08);
    }
    @media (max-width: 767.98px) {
      .public-shell-nav { display: none; }
      .public-shell-hamburger { display: flex; }
      .footer-grid { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>
  <header class="public-shell-topbar">
    <div class="container inner">
      <a aria-label="FansFollow.me" class="public-shell-brand" href="{{ route('home') }}">
        <img src="/public/logo-monogram.png" alt="FansFollow.me" height="40">
      </a>
      <nav class="public-shell-nav" aria-label="Primary">
        <a href="{{ route('page.for-creators') }}">For Creators</a>
        <a href="{{ route('page.fans') }}">For Fans</a>
        <a href="{{ route('page.celebrities') }}">Celebrities</a>
        <a href="{{ route('page.explore') }}">Explore</a>
        <a class="active" href="{{ route('page.revenue-streams') }}">Revenue Streams</a>
      </nav>
      <div class="public-shell-actions">
        <a class="public-shell-button btn-primary" href="{{ route('register') }}?role=creator">Apply to be a Creator</a>
      </div>
    </div>
  </header>

  <main>
    <section class="page-hero">
      <div class="container">
        <h1>Creator Revenue Streams</h1>
        <p>Keep <strong>80%+</strong> of what you earn. Stack subscriptions, tips, paid content, shop sales and more — all on one platform built for fitness, martial arts and combat sports creators.</p>
        <div class="share-banner">
          <div>
            <div class="big">80%+ revenue share</div>
            <p style="margin:.35rem 0 0;color:#e2e8f0;">Industry-leading split on every stream. High-volume talent can negotiate higher rates.</p>
          </div>
        </div>
        <div class="cta-row">
          <a class="cta-btn" href="{{ route('register') }}?role=creator">Apply to be a Creator</a>
          <a class="cta-btn-outline" href="{{ route('page.for-creators') }}">See For Creators</a>
        </div>

        <h2 style="font-size:1.35rem;font-weight:800;color:#fff;margin:0 0 1rem;">Ways you earn</h2>
        <div class="stream-grid">
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#f97316,#ea580c);"><i class="fas fa-repeat"></i></div><h3>Subscriptions</h3><p>Recurring monthly income from your fan community with exclusive member content.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#a855f7,#7c3aed);"><i class="fas fa-comments"></i></div><h3>Paid Chats</h3><p>Get paid for private messages and direct conversations with fans.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#ec4899,#db2777);"><i class="fas fa-gift"></i></div><h3>Tips &amp; Gifts</h3><p>One-off support, tip jars and animated gifts from fans who back your work.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#3b82f6,#2563eb);"><i class="fas fa-lock"></i></div><h3>PPV Content</h3><p>Sell pay-per-view posts, premium videos and locked exclusive drops.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#14b8a6,#0d9488);"><i class="fas fa-phone"></i></div><h3>Phone Calls</h3><p>Paid voice coaching and consultations on your schedule and rates.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);"><i class="fas fa-video"></i></div><h3>Video Sessions</h3><p>One-on-one or group video training, coaching and live consults.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);"><i class="fas fa-envelope"></i></div><h3>Video Messages</h3><p>Personalised video requests fans order and unlock after you deliver.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#10b981,#059669);"><i class="fas fa-shopping-bag"></i></div><h3>Shop &amp; Merch</h3><p>Sell branded gear, supplements and digital downloads in your store.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#f97316,#a855f7);"><i class="fas fa-dumbbell"></i></div><h3>Training Programs</h3><p>Structured fitness and nutrition programs sold as digital products.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#ef4444,#b91c1c);"><i class="fas fa-tv"></i></div><h3>Live Streams</h3><p>Go live in 4K; charge for exclusive pay-per-view events and Q&amp;As.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#06b6d4,#0891b2);"><i class="fas fa-users"></i></div><h3>Group Training</h3><p>Host paid group sessions and build a community around shared workouts.</p></div>
          <div class="stream-card"><div class="stream-icon" style="background:linear-gradient(135deg,#a855f7,#ec4899);"><i class="fas fa-film"></i></div><h3>Casting &amp; Film</h3><p>Get discovered for martial arts film roles and brand partnerships.</p></div>
        </div>

        <h2 style="font-size:1.35rem;font-weight:800;color:#fff;margin:0 0 1rem;">How payouts work</h2>
        <div class="stream-grid">
          <div class="stream-card"><h3>Keep 80%+</h3><p>Clear reporting on every stream. No surprise fees buried in the fine print.</p></div>
          <div class="stream-card"><h3>Get paid your way</h3><p>Bank transfer or crypto with low fees and fast processing.</p></div>
          <div class="stream-card"><h3>VIP rates</h3><p>Negotiate higher revenue share as your volume grows.</p></div>
        </div>

        <div class="cta-row">
          <a class="cta-btn" href="{{ route('register') }}?role=creator">Apply to be a Creator</a>
          <a class="cta-btn-outline" href="{{ route('page.support') }}">Support Center</a>
        </div>
      </div>
    </section>
  </main>

  <footer class="public-shell-footer">
    <div class="container">
      <div class="footer-topline"></div>
      <div class="footer-grid">
        <div class="footer-links">
          <h3>For Creators</h3>
          <a href="{{ route('page.revenue-streams') }}">Revenue Streams</a>
          <a href="{{ route('register') }}?role=creator">Getting Started</a>
          <a href="{{ route('page.for-creators') }}">For Creators</a>
        </div>
        <div class="footer-links">
          <h3>Revenue Streams</h3>
          <span>Subscriptions · Tips · PPV</span>
          <span>Shop · Calls · Video</span>
        </div>
        <div class="footer-links">
          <h3>Support</h3>
          <a href="{{ route('page.support') }}">Help Center</a>
          <a href="{{ route('page.contact') }}">Contact Us</a>
        </div>
        <div class="footer-links">
          <h3>Coming Soon</h3>
          <span>Creator Competitions</span>
          <span>Gym Monster</span>
          <span>Mini Leagues</span>
          <span>Mobile App</span>
        </div>
      </div>
      <div class="footer-bottomline"></div>
      <div class="footer-bottom">
        <div class="footer-legal">© 2026 FansFollow.me · BTC/ETH/USDT/SOL Accepted</div>
        <div class="footer-policies">
          <a href="{{ route('page.privacy') }}">Privacy</a>
          <a href="{{ route('page.terms') }}">Terms</a>
          <a href="{{ route('page.cookies') }}">Cookies</a>
          <a href="{{ route('page.faq') }}">FAQ</a>
        </div>
        <div class="footer-follow">
          <span>Follow us:</span>
          <div class="footer-social">
            <a href="https://www.facebook.com/profile.php?id=100089966703593" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/fansfollowdotme" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
