<!-- FOOTER - Match fansfollowme.com design exactly -->
<div class="py-5 @auth d-none d-lg-block @endauth @if (auth()->check() && auth()->user()->dark_mode == 'off' || auth()->guest()) footer_background_color footer_text_color @else bg-white @endif @if (auth()->check() && auth()->user()->dark_mode == 'off' && $settings->footer_background_color == '#ffffff' || auth()->guest() && $settings->footer_background_color == '#ffffff' ) border-top @endif" style="position: relative; overflow: hidden;">
  
  {{-- Decorative background elements --}}
  <div style="position: absolute; top: 0; left: 25%; width: 384px; height: 384px; background: var(--ffm-orange); border-radius: 50%; mix-blend-mode: multiply; filter: blur(96px); opacity: 0.1;"></div>
  <div style="position: absolute; bottom: 0; right: 25%; width: 384px; height: 384px; background: var(--ffm-purple); border-radius: 50%; mix-blend-mode: multiply; filter: blur(96px); opacity: 0.1;"></div>

<footer class="container position-relative" style="z-index: 1;">
  {{-- Gradient separator line --}}
  <div class="footer-gradient-line"></div>

  <div class="row g-4">
    {{-- Logo and description --}}
    <div class="col-md-4">
      <a href="{{url('/')}}">
        <img src="{{url('fans-foloow-me-logo-final-file--png-version.png')}}" alt="{{$settings->title}}" class="max-w-125 mb-3">
      </a>
      <p class="mb-4" style="max-width: 300px; color: var(--ffm-text-muted); font-size: 0.875rem;">
        The premier creator platform for fitness enthusiasts, athletes, and sports influencers. Monetize your passion and build your community.
      </p>
      
      @if ($settings->facebook != ''
          || $settings->twitter != ''
          || $settings->instagram != ''
          || $settings->pinterest != ''
          || $settings->youtube != ''
          || $settings->github != ''
          || $settings->tiktok != ''
          || $settings->snapchat != ''
          || $settings->telegram != ''
          || $settings->reddit != ''
          || $settings->linkedin != ''
          || $settings->threads != ''
          )
      <div class="w-100">
        <h6 class="text-uppercase mb-3">Follow Us</h6>
        <ul class="list-inline list-social m-0">
          @if ($settings->twitter != '')
          <li class="list-inline-item"><a href="{{$settings->twitter}}" target="_blank" class="ico-social"><i class="bi-twitter-x"></i></a></li>
        @endif

        @if ($settings->facebook != '')
          <li class="list-inline-item"><a href="{{$settings->facebook}}" target="_blank" class="ico-social"><i class="fab fa-facebook"></i></a></li>
          @endif

          @if ($settings->instagram != '')
          <li class="list-inline-item"><a href="{{$settings->instagram}}" target="_blank" class="ico-social"><i class="fab fa-instagram"></i></a></li>
        @endif

          @if ($settings->pinterest != '')
          <li class="list-inline-item"><a href="{{$settings->pinterest}}" target="_blank" class="ico-social"><i class="fab fa-pinterest"></i></a></li>
        @endif

          @if ($settings->youtube != '')
          <li class="list-inline-item"><a href="{{$settings->youtube}}" target="_blank" class="ico-social"><i class="fab fa-youtube"></i></a></li>
        @endif

          @if ($settings->github != '')
          <li class="list-inline-item"><a href="{{$settings->github}}" target="_blank" class="ico-social"><i class="fab fa-github"></i></a></li>
        @endif

          @if ($settings->tiktok != '')
          <li class="list-inline-item"><a href="{{$settings->tiktok}}" target="_blank" class="ico-social"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/></svg></a></li>
        @endif

          @if ($settings->snapchat != '')
          <li class="list-inline-item"><a href="{{$settings->snapchat}}" target="_blank" class="ico-social"><i class="bi-snapchat"></i></a></li>
        @endif

          @if ($settings->telegram != '')
          <li class="list-inline-item"><a href="{{$settings->telegram}}" target="_blank" class="ico-social"><i class="bi-telegram"></i></a></li>
        @endif

          @if ($settings->reddit != '')
          <li class="list-inline-item"><a href="{{$settings->reddit}}" target="_blank" class="ico-social"><i class="bi-reddit"></i></a></li>
        @endif

          @if ($settings->linkedin != '')
          <li class="list-inline-item"><a href="{{$settings->linkedin}}" target="_blank" class="ico-social"><i class="bi-linkedin"></i></a></li>
        @endif

          @if ($settings->threads != '')
          <li class="list-inline-item"><a href="{{$settings->threads}}" target="_blank" class="ico-social"><i class="bi-threads"></i></a></li>
        @endif
        </ul>
      </div>
    @endif

    <li>
      <div id="installContainer" class="display-none">
        <button class="btn btn-primary w-100 rounded-pill mb-4 mt-3" id="butInstall" type="button">
          <i class="bi-phone mr-1"></i> {{ __('general.install_web_app') }}
        </button>
      </div>
    </li>

    </div>
    
    {{-- For Creators column --}}
    <div class="col-md-2">
      <h6>For Creators</h6>
      <ul class="list-unstyled">
        <li><a class="link-footer" href="{{ url('signup') }}">Getting Started</a></li>
        <li><a class="link-footer" href="{{ url('creators') }}">Personal Video Messages</a></li>
      </ul>
    </div>
    
    {{-- Revenue Streams column --}}
    <div class="col-md-2">
      <h6>Revenue Streams</h6>
      <ul class="list-unstyled">
        <li><a class="link-footer" href="{{ url('creators') }}">Content Monetization</a></li>
        <li><a class="link-footer" href="{{ url('creators') }}">Paid Phone Calls</a></li>
        <li><a class="link-footer" href="{{ url('creators') }}">Text Coaching</a></li>
        <li><a class="link-footer" href="{{ url('creators') }}">Video Consultations</a></li>
      </ul>
    </div>
    
    {{-- Support column --}}
    <div class="col-md-2">
      <h6>Support</h6>
      <ul class="list-unstyled">
        <li><a class="link-footer" href="{{ url('contact') }}">Help Center</a></li>
        <li><a class="link-footer" href="{{ url('contact') }}">Contact Us</a></li>
        <li><a class="link-footer" href="{{ url('contact') }}">Creator Resources</a></li>
        <li><a class="link-footer" href="{{ url('contact') }}">Community</a></li>
      </ul>
    </div>
    
    {{-- Advanced column --}}
    <div class="col-md-2">
      <h6>Advanced</h6>
      <ul class="list-unstyled">
        <li><a class="link-footer" href="{{ url('business') }}#tokens">Token Ecosystem</a></li>
        <li><a class="link-footer" href="{{ url('business') }}#presale">Presale Info</a></li>
      </ul>
    </div>
  </div>
</footer>
</div>

{{-- Copyright footer --}}
<footer class="py-3 @if (auth()->check() && auth()->user()->dark_mode == 'off' || auth()->guest() ) footer_background_color @endif text-center" style="position: relative;">
  {{-- Gradient separator --}}
  <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; overflow: hidden;">
    <div style="position: absolute; inset: 0; background: linear-gradient(to right, transparent, var(--ffm-orange), transparent); opacity: 0.8;"></div>
  </div>

  <div class="container">
    <div class="row">
    @auth
      <div class="d-lg-none d-block pb-5 mb-2 w-100">
        @include('includes.footer-tiny')
      </div>
    @endauth
      <div class="col-md-12 copyright @auth d-none d-lg-block @endauth">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
          <div>
            &copy; {{date('Y')}} {{$settings->title}}, {{__('emails.rights_reserved')}}
          </div>
          <div class="mt-2 mt-md-0">
            <span style="color: var(--ffm-text-muted); font-size: 0.875rem;">
              &#x2026; BTC/ETH/USDT/SOL Accepted
            </span>
          </div>
        </div>

        {{-- Footer links matching fansfollowme.com --}}
        <div class="mt-2">
          <a href="{{ url('p/privacy') }}" style="color: var(--ffm-text-muted); font-size: 0.875rem;">Privacy Policy</a>
          <span style="color: var(--ffm-text-muted); margin: 0 0.5rem;">&bull;</span>
          <a href="{{ url('p/terms') }}" style="color: var(--ffm-text-muted); font-size: 0.875rem;">Terms of Service</a>
          <span style="color: var(--ffm-text-muted); margin: 0 0.5rem;">&bull;</span>
          <a href="{{ url('p/cookies') }}" style="color: var(--ffm-text-muted); font-size: 0.875rem;">Cookie Policy</a>
          <span style="color: var(--ffm-text-muted); margin: 0 0.5rem;">&bull;</span>
          <a href="{{ url('faq') }}" style="color: var(--ffm-text-muted); font-size: 0.875rem;">FAQ</a>
        </div>

        @if ($settings->show_address_company_footer)
        <small class="d-block mt-2" style="color: var(--ffm-text-muted);">
          {{ $settings->company }} - {{ __('general.address') }}: {{ $settings->address }} {{ $settings->city }} {{ $settings->country }}
        </small>
        @endif
      </div>
    </div>
  </div>
</footer>
