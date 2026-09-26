{{-- Guest: marketing header (unchanged). Auth: product nav = logo + hamburger menu. --}}
@auth
@php
    $me = auth()->user();
    $homeHref = route('page.explore');
    $profileHref = route('profile', $me->username);
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
    <a href="{{ $homeHref }}">Home</a>
    <a href="{{ $profileHref }}">My profile</a>
    @if ($me->isCreator())
        <a href="{{ route('creator.dashboard') }}">Studio</a>
    @endif
    @if (! $me->isAdmin())
        <a href="{{ route('dashboard') }}">Dashboard</a>
    @endif
    <a href="{{ route('messages.index') }}">Messages</a>
    <a href="{{ route('notifications.index') }}">Alerts</a>
    <a href="{{ route('settings.page') }}">Settings</a>
    <a href="{{ route('wallet.show') }}">Wallet</a>
    @if ($me->isAdmin())
        <a href="{{ route('admin.dashboard') }}">Admin</a>
    @endif
    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit" class="mobile-cta-btn w-100" style="cursor:pointer;">Log out</button>
    </form>
</div>
@else
@include('partials.header')
@endauth
