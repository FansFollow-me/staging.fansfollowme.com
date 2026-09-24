<header class="public-shell-topbar">
    <div class="container inner">
      <a aria-label='FansFollow.me' class='public-shell-brand' href="{{ route('home') }}">
        <img src="/public/logo-monogram.png" alt="FansFollow.me" height="40">
      </a>
      <nav class="public-shell-nav d-none d-lg-flex" aria-label="Primary">
        <a href="{{ route('page.for-creators') }}">For Creators</a>
        <a href="{{ route('page.fans') }}">For Fans</a>
        <a href="{{ route('page.celebrities') }}">Celebrities</a>
        <a href="{{ route('page.explore') }}">Explore</a>
        <details class="public-shell-more">
          <summary>More</summary>
          <div class="public-shell-nav-panel">
            <a href="{{ route('page.casting') }}">&#127912; <span>Movie Casting</span></a>
            <a href="{{ route('page.live-streams') }}">&#128308; <span>Live Streams</span></a>
            <a href="{{ route('page.business') }}">&#128188; <span>Business</span></a>
            <a href="{{ route('page.support') }}">&#128172; <span>Support</span></a>
            @auth
              @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
              <a href="{{ route('join.my-qr') }}">&#128241; <span>My QR code</span></a>
              @endif
            @endauth
          </div>
        </details>
      </nav>
      <div class="public-shell-actions">
        @guest
          <a class="btn btn-primary public-shell-button" style="background: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%); background-image: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%); border-color: transparent; box-shadow: 0 14px 28px rgba(249, 115, 22, .24);" href="{{ route('register') }}">Get Started</a>
          <a class="btn btn-outline-primary public-shell-button" href="{{ route('login') }}">Login</a>
        @else
          @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
          <a class="btn btn-outline-primary public-shell-button" href="{{ route('creator.dashboard') }}">Studio</a>
          @endif
          @if (auth()->user()->isAdmin())
          <a class="btn btn-outline-primary public-shell-button" href="{{ route('admin.dashboard') }}">Admin</a>
          @endif
          <a class="btn btn-primary public-shell-button" style="background: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%); background-image: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%); border-color: transparent; box-shadow: 0 14px 28px rgba(249, 115, 22, .24);" href="{{ route('dashboard') }}">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}" class="m-0 d-inline">@csrf<button type="submit" class="btn btn-outline-primary public-shell-button">Logout</button></form>
        @endguest
      </div>
      <button class="public-shell-hamburger" onclick="document.querySelector('.mobile-menu-overlay').classList.add('is-open');document.querySelector('.mobile-menu-panel').classList.add('is-open')" aria-label="Open menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </header>

  <div class="mobile-menu-overlay" onclick="this.classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')"></div>
  <div class="mobile-menu-panel">
    <div class="mobile-menu-close">
      <button onclick="document.querySelector('.mobile-menu-overlay').classList.remove('is-open');document.querySelector('.mobile-menu-panel').classList.remove('is-open')" aria-label="Close menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="mobile-menu-section-label">Navigation</div>
    <a href="{{ route('page.for-creators') }}">For Creators</a>
    <a href="{{ route('page.fans') }}">For Fans</a>
    <a href="{{ route('page.celebrities') }}">Celebrities</a>
    <a href="{{ route('page.explore') }}">Explore</a>
    <div class="mobile-menu-section-label" style="margin-top:.5rem">More</div>
    <a href="{{ route('page.casting') }}">&#127912; Movie Casting</a>
    <a href="{{ route('page.live-streams') }}">&#128308; Live Streams</a>
    <a href="{{ route('page.business') }}">&#128188; Business</a>
    <a href="{{ route('page.support') }}">&#128172; Support</a>
    @auth
      @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
      <a href="{{ route('join.my-qr') }}">&#128241; My QR code</a>
      @endif
    @endauth
    <a href="{{ route('login') }}" style='margin-top:1rem;color:#94a3b8;font-weight:600'>Login</a>
    <a class='mobile-cta-btn' href="{{ route('register') }}">Get Started</a>
  </div>

