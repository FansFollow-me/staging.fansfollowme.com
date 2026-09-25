<header class="public-shell-topbar">
    <div class="container inner">
        <a class="public-shell-brand" href="{{ route('home') }}" aria-label="FansFollow.me">
            <img src="/public/logo-monogram.png" alt="FansFollow.me" height="40">
        </a>
        <nav class="public-shell-nav d-none d-lg-flex" aria-label="Primary">
            <a href="{{ route('page.for-creators') }}">For Creators</a>
            <a href="{{ route('page.fans') }}">For Fans</a>
            <a href="{{ route('page.celebrities') }}">Celebrities</a>
            <a href="{{ route('page.explore') }}">Explore</a>
            @auth
                <a href="{{ route('reels.index') }}">Reels</a>
                <a href="{{ route('stories.index') }}">Stories</a>
                <a href="{{ route('coming-soon') }}">Coming Soon</a>
            @else
                <a href="{{ route('coming-soon') }}">Coming Soon</a>
            @endauth
            <details class="public-shell-more">
                <summary>More</summary>
                <div class="public-shell-nav-panel">
                    <a href="{{ route('page.casting') }}">🎬 <span>Movie Casting</span></a>
                    <a href="{{ route('page.live-streams') }}">🔴 <span>Live Streams</span></a>
                    <a href="{{ route('page.business') }}">💼 <span>Business</span></a>
                    <a href="{{ route('page.support') }}">💬 <span>Support</span></a>
                    <a href="{{ route('page.qr-signups') }}">📱 <span>QR Sign-Ups</span></a>
                    @auth
                        @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
                            <a href="{{ route('join.my-qr') }}">📱 <span>My QR code</span></a>
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
                <a class="btn btn-primary public-shell-button" style="background: var(--cta-gradient); background-image: var(--cta-gradient); border-color: transparent;" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="btn btn-outline-primary public-shell-button" href="{{ route('notifications.index') }}">Alerts</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0 d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link public-shell-button text-muted">Logout</button>
                </form>
            @endguest
        </div>
        <button class="public-shell-hamburger" type="button" aria-label="Open menu" onclick="document.querySelector('.mobile-menu-overlay')?.classList.add('is-open');document.querySelector('.mobile-menu-panel')?.classList.add('is-open')">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </div>
</header>

<div class="mobile-menu-overlay" onclick="this.classList.remove('is-open');document.querySelector('.mobile-menu-panel')?.classList.remove('is-open')"></div>
<div class="mobile-menu-panel">
    <div class="mobile-menu-close">
        <button type="button" aria-label="Close menu" onclick="document.querySelector('.mobile-menu-overlay')?.classList.remove('is-open');document.querySelector('.mobile-menu-panel')?.classList.remove('is-open')">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    <div class="mobile-menu-section-label">Navigation</div>
    <a href="{{ route('page.for-creators') }}">For Creators</a>
    <a href="{{ route('page.fans') }}">For Fans</a>
    <a href="{{ route('page.celebrities') }}">Celebrities</a>
    <a href="{{ route('page.explore') }}">Explore</a>
    <div class="mobile-menu-section-label" style="margin-top:.5rem">More</div>
    <a href="{{ route('page.casting') }}">🎬 Movie Casting</a>
    <a href="{{ route('page.live-streams') }}">🔴 Live Streams</a>
    <a href="{{ route('page.business') }}">💼 Business</a>
    <a href="{{ route('page.support') }}">💬 Support</a>
    <a href="{{ route('page.qr-signups') }}">📱 QR Sign-Ups</a>
    @auth
        @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
        <a href="{{ route('join.my-qr') }}">📱 My QR code</a>
        @endif
    @endauth
    @guest
        <a href="{{ route('login') }}" style="margin-top:1rem;color:#94a3b8;font-weight:600">Login</a>
        <a href="{{ route('register') }}" class="mobile-cta-btn">Get Started</a>
    @else
        <a href="{{ route('dashboard') }}" class="mobile-cta-btn">Dashboard</a>
    @endguest
</div>
