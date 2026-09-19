<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FansFollow.me') — FansFollow</title>
    <meta name="description" content="@yield('meta_description', 'FansFollow.me is the global fitness and martial arts creator platform for subscriptions, coaching, direct fan access, and live creator discovery.')">
    <link rel="icon" href="/public/logo-monogram.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ffm-app.css') }}" rel="stylesheet">
    @stack('head')
    <style>
        :root {
            color-scheme: dark;
            --ffm-bg: #0B0F1A;
            --ffm-card: #111827;
            --ffm-panel: #151B2C;
            --ffm-border: #1f2937;
            --ffm-orange: #f97316;
            --ffm-purple: #a855f7;
            --ffm-text: #e5e7eb;
            --ffm-muted: #9ca3af;
            --ffm-cta: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%);
        }
        body {
            background: var(--ffm-bg);
            color: var(--ffm-text);
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        .ffm-shell { min-height: 100vh; display: flex; flex-direction: column; }
        .ffm-shell main { flex: 1; }
        .btn-ffm {
            background: var(--ffm-cta);
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 12px;
            min-height: 44px;
        }
        .btn-ffm:hover { filter: brightness(1.08); color: #fff; }
        .card-ffm {
            background: rgba(15,23,42,.84);
            border: 1px solid rgba(148,163,184,.12);
            border-radius: 16px;
        }
        .alert-inline { border-radius: 12px; }
    </style>
</head>
<body>
<div class="ffm-shell">
    @include('partials.nav')
    @hasSection('fullbleed')
        <main class="public-shell-content">
            @yield('fullbleed')
        </main>
    @else
        <main class="public-shell-content py-4">
            <div class="container">
                @if (session('status'))
                    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    @endif
    @include('partials.footer')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>if (window.lucide) lucide.createIcons();</script>
@stack('scripts')
</body>
</html>
