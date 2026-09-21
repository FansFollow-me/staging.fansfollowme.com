<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme-color" content="#f97316">
  <meta name="robots" content="noindex">
  <title>{{ $title }}</title>
  <link href="data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 64 64%27%3E%3Crect x=%270%27 y=%270%27 width=%2764%27 height=%2764%27 rx=%2712%27 fill=%27%230d1119%27/%3E%3Ctext x=%2732%27 y=%2744%27 font-size=%2736%27 font-weight=%27bold%27 text-anchor=%27middle%27 fill=%27%23f97316%27 font-family=%27Arial,sans-serif%27%3EF%3C/text%3E%3C/svg%3E" rel="icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
      min-height: 100vh;
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
      background:
        radial-gradient(700px 320px at 20% 0%, rgba(249,115,22,.12), transparent 55%),
        radial-gradient(600px 280px at 85% 10%, rgba(147,51,234,.14), transparent 50%),
        var(--bg);
      color: var(--text);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
    }
    .card {
      width: min(520px, 100%);
      background: var(--panel);
      border: 1px solid var(--line);
      border-radius: 18px;
      box-shadow: 0 18px 54px rgba(0,0,0,.36);
      padding: 2.25rem 1.75rem 1.75rem;
      text-align: center;
    }
    .mark {
      width: 72px;
      height: 72px;
      margin: 0 auto 1.25rem;
      border-radius: 16px;
      background:
        radial-gradient(circle at 50% 70%, rgba(249,115,22,.35), transparent 55%),
        #0f172a;
      border: 1px solid rgba(249,115,22,.4);
      display: grid;
      place-items: center;
      box-shadow: 0 0 28px rgba(249,115,22,.28);
    }
    .mark svg { width: 36px; height: 36px; }
    .badge {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      padding: .35rem .85rem;
      border-radius: 999px;
      background: var(--gradient);
      color: #fff;
      font-size: .7rem;
      font-weight: 800;
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: 1rem;
    }
    h1 {
      margin: 0 0 .65rem;
      font-size: clamp(1.65rem, 4vw, 2.15rem);
      font-weight: 900;
      letter-spacing: -0.03em;
      color: #fff;
      line-height: 1.15;
    }
    .lead {
      margin: 0 0 1.75rem;
      color: var(--muted);
      font-size: 1rem;
      line-height: 1.65;
      font-weight: 500;
    }
    .actions {
      display: flex;
      flex-wrap: wrap;
      gap: .65rem;
      justify-content: center;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 46px;
      padding: .7rem 1.25rem;
      border-radius: 12px;
      font-weight: 700;
      font-size: .92rem;
      text-decoration: none;
      transition: transform .2s ease, filter .2s ease, background .2s ease;
    }
    .btn-primary {
      background: var(--gradient);
      color: #fff;
      border: none;
      box-shadow: 0 10px 24px rgba(249,115,22,.28);
    }
    .btn-primary:hover { transform: scale(1.03); filter: brightness(1.06); color: #fff; }
    .btn-ghost {
      background: rgba(30,41,59,.85);
      color: var(--text);
      border: 1px solid rgba(255,255,255,.12);
    }
    .btn-ghost:hover { background: rgba(51,65,85,.9); color: #fff; }
    .foot {
      margin-top: 1.5rem;
      font-size: .78rem;
      color: #64748b;
    }
    .foot a { color: #94a3b8; }
  </style>
</head>
<body>
  <main class="card" role="status" aria-live="polite">
    <div class="mark" aria-hidden="true">
      <svg viewBox="0 0 24 24" fill="none" stroke="#fb923c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 6L9 17l-5-5"/>
      </svg>
    </div>
    <div class="badge">Message received</div>
    <h1>{{ $headline }}</h1>
    <p class="lead">{{ $lead }}</p>
    <div class="actions">
      <a class="btn btn-primary" href="{{ $primaryUrl }}">{{ $primaryLabel }}</a>
      <a class="btn btn-ghost" href="{{ $secondaryUrl }}">{{ $secondaryLabel }}</a>
    </div>
    <p class="foot">FansFollow.me · <a href="{{ route('page.support') }}">Support</a> · <a href="{{ route('home') }}">Home</a></p>
  </main>
</body>
</html>
