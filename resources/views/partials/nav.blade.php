{{-- Guest: marketing header (unchanged). Auth: product nav = logo + hamburger menu. --}}
@auth
@php
    $me = auth()->user();
    $homeExploreHref = route('page.explore');
    $profileHref = route('profile', $me->username);
    $dashboardHref = $me->isAdmin() ? route('admin.dashboard') : route('dashboard');
@endphp
<header class="public-shell-topbar">
    <div class="container inner">
        <a class="public-shell-brand" href="{{ route('home') }}" aria-label="FansFollow.me">
            <img src="/public/logo-monogram.png" alt="FansFollow.me" height="40">
        </a>
        <button class="public-shell-hamburger public-shell-hamburger--product" type="button" aria-label="Open menu"
                onclick="document.querySelector('.mobile-menu-overlay')?.classList.add('is-open');document.querySelector('.mobile-menu-panel')?.classList.add('is-open')">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>
</header>

<div class="mobile-menu-overlay" onclick="this.classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')"></div>
<div class="mobile-menu-panel" role="dialog" aria-label="Product menu">
    <div class="mobile-menu-close">
        <button type="button" aria-label="Close menu" onclick="document.querySelector('.mobile-menu-overlay').classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    <div class="mobile-menu-section-label">Menu</div>
    <a href="{{ $homeExploreHref }}">Home / Explore</a>
    <a href="{{ $profileHref }}">My profile</a>
    @if ($me->isCreator())
        <a href="{{ route('creator.dashboard') }}">Studio</a>
    @endif
    <a href="{{ $dashboardHref }}">Dashboard</a>
    <a href="{{ route('messages.index') }}">Messages</a>
    <a href="{{ route('notifications.index') }}">Notifications</a>
    <a href="{{ route('settings.page') }}">Settings</a>
    @if ($me->isAdmin())
        <a href="{{ route('admin.dashboard') }}">Admin</a>
    @endif
    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit" class="mobile-cta-btn w-100" style="cursor:pointer;">Log out</button>
    </form>
</div>
@else
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
            <a href="{{ route('coming-soon') }}">Coming Soon</a>
            <details class="public-shell-more">
                <summary>More</summary>
                <div class="public-shell-nav-panel">
                    <a href="{{ route('page.casting') }}">🎬 <span>Movie Casting</span></a>
                    <a href="{{ route('page.live-streams') }}">🔴 <span>Live Streams</span></a>
                    <a href="{{ route('page.business') }}">💼 <span>Business</span></a>
                    <a href="{{ route('page.support') }}">💬 <span>Support</span></a>
                    <a href="{{ route('page.qr-signups') }}">📱 <span>QR Sign-Ups</span></a>
                </div>
            </details>
        </nav>
        <div class="public-shell-actions">
            <a class="btn btn-primary public-shell-button" style="background: var(--cta-gradient); background-image: var(--cta-gradient); border-color: transparent; box-shadow: 0 14px 28px rgba(249, 115, 22, .24);" href="{{ route('register') }}">Get Started</a>
            <a class="btn btn-outline-primary public-shell-button" href="{{ route('login') }}">Login</a>
        </div>
        <button class="public-shell-hamburger" type="button" aria-label="Open menu" onclick="document.querySelector('.mobile-menu-overlay')?.classList.add('is-open');document.querySelector('.mobile-menu-panel')?.classList.add('is-open')">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </div>
</header>

<div class="mobile-menu-overlay" onclick="this.classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')"></div>
<div class="mobile-menu-panel">
    <div class="mobile-menu-close">
        <button type="button" aria-label="Close menu" onclick="document.querySelector('.mobile-menu-overlay')?.classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')">
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
    <a href="{{ route('login') }}" style="margin-top:1rem;color:#94a3b8;font-weight:600">Login</a>
    <a href="{{ route('register') }}" class="mobile-cta-btn">Get Started</a>
</div>
@endauth
