@extends('layouts.appnew')

@section('content')
  {{-- ============================================
       HERO SECTION - Match fansfollowme.com
       ============================================ --}}
  <section class="jumbotron homepage m-0">
    <div class="container">
      <div class="row align-items-center">
        {{-- Left column: Text content --}}
        <div class="col-lg-6 second mb-5 mb-lg-0">
          <h1 class="display-4 mb-3" style="font-size: 2.5rem; font-weight: 900; line-height: 1.1;">
            {{ $settings->title }} — where fans become friends
          </h1>

          <div class="mb-4">
            <p class="text-orange fw-semibold mb-3" style="font-size: 1rem;">
              For Fitness, Bodybuilding and Martial Arts Creators
            </p>
            <p class="lead mb-0" style="font-size: 1rem; color: var(--ffm-text-secondary); line-height: 1.7;">
              Built for fitness coaches, bodybuilders, nutrition experts, martial artists and combat sports creators to earn from fans worldwide through content, coaching and direct fan access.
            </p>
          </div>

          <div class="d-flex flex-column flex-sm-row gap-3 mb-4">
            @if (!$settings->disable_creators_section)
              <a href="{{url('creators')}}" class="btn btn-lg btn-main btn-primary px-4 d-flex align-items-center justify-content-center gap-2 animate-glow-pulse" role="button">
                <i class="bi bi-search"></i>
                <span>{{__('general.explore')}} Creators</span>
              </a>
            @endif

            <a class="btn btn-lg btn-main btn-light px-4 d-flex align-items-center justify-content-center gap-2 toggleRegister btn-arrow" href="{{ $settings->registration_active == '1' ? url('signup') : url('login')}}">
              <i class="bi bi-person-plus"></i>
              <span>{{__('general.getting_started')}}</span>
            </a>
          </div>
        </div>

        {{-- Right column: Hero image --}}
        <div class="col-lg-6 first text-center">
          <div class="hero-image-wrapper">
            <img src="{{url('img', $settings->home_index)}}" 
                 class="img-center img-fluid" 
                 alt="{{$settings->title}} Creator Platform"
                 style="width: 85%; max-width: 480px; margin: 0 auto;">
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- ./ Hero Section --}}

  {{-- ============================================
       FEATURES SECTION - Glass morphism cards
       ============================================ --}}
  <div class="section py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h1 class="txt-black" style="font-size: 2rem; font-weight: 900;">
          One home for fitness creators and their fans
        </h1>
        <p class="mx-auto" style="max-width: 700px; color: var(--ffm-text-secondary);">
          {{ $settings->title }} brings fighters, coaches, fitness influencers, sports professionals and actors with fitness-based content together on one platform, so fans can find them in one place and creators can build real relationships.
        </p>
      </div>

      <div class="row g-4">
        {{-- Feature 1: Keep Revenue --}}
        <div class="col-lg-3 col-md-6">
          <div class="feature-card text-center h-100">
            <div class="feature-icon mb-3">
              <i class="bi bi-cash-stack"></i>
            </div>
            <h4>Keep 80%+ Revenue</h4>
            <p class="mb-0">Keep more of what you earn with a creator-first revenue share.</p>
          </div>
        </div>

        {{-- Feature 2: Revenue Streams --}}
        <div class="col-lg-3 col-md-6">
          <div class="feature-card text-center h-100">
            <div class="feature-icon mb-3">
              <i class="bi bi-lightning-charge"></i>
            </div>
            <h4>17+ Revenue Streams</h4>
            <p class="mb-0">Earn through subscriptions, coaching, premium content, calls, tips and more.</p>
          </div>
        </div>

        {{-- Feature 3: Global Payments --}}
        <div class="col-lg-3 col-md-6">
          <div class="feature-card text-center h-100">
            <div class="feature-icon mb-3">
              <i class="bi bi-globe2"></i>
            </div>
            <h4>Global Payments</h4>
            <p class="mb-0">Accept payments from fans worldwide with flexible payment options.</p>
          </div>
        </div>

        {{-- Feature 4: Direct Fan Connection --}}
        <div class="col-lg-3 col-md-6">
          <div class="feature-card text-center h-100">
            <div class="feature-icon mb-3">
              <i class="bi bi-chat-dots"></i>
            </div>
            <h4>Direct Fan Connection</h4>
            <p class="mb-0">Build stronger fan relationships through private access and paid interactions.</p>
          </div>
        </div>

        {{-- Feature 5: Mobile Content --}}
        <div class="col-lg-3 col-md-6">
          <div class="feature-card text-center h-100">
            <div class="feature-icon mb-3">
              <i class="bi bi-camera"></i>
            </div>
            <h4>Mobile Content Creation</h4>
            <p class="mb-0">Create and upload content directly from your phone.</p>
          </div>
        </div>

        {{-- Feature 6: Instant Messaging --}}
        <div class="col-lg-3 col-md-6">
          <div class="feature-card text-center h-100">
            <div class="feature-icon mb-3">
              <i class="bi bi-telephone"></i>
            </div>
            <h4>Instant Messaging</h4>
            <p class="mb-0">Chat privately with fans in real time.</p>
          </div>
        </div>

        {{-- Feature 7: Live Streaming --}}
        <div class="col-lg-3 col-md-6">
          <div class="feature-card text-center h-100">
            <div class="feature-icon mb-3">
              <i class="bi bi-broadcast"></i>
            </div>
            <h4>Live Streaming</h4>
            <p class="mb-0">Go live to your audience from any device.</p>
          </div>
        </div>

        {{-- Feature 8: QR Sign-Ups --}}
        <div class="col-lg-3 col-md-6">
          <div class="feature-card text-center h-100">
            <div class="feature-icon mb-3">
              <i class="bi bi-qr-code"></i>
            </div>
            <h4>In-Person QR Sign-Ups</h4>
            <p class="mb-0">Let fans join and pay on the spot by scanning your unique QR code at events and gyms.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ============================================
       FOR FANS SECTION
       ============================================ --}}
  <div class="section py-5">
    <div class="container">
      <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center px-4 py-2 rounded-pill mb-4" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3);">
          <i class="bi bi-people text-orange me-2"></i>
          <span class="text-orange fw-semibold" style="font-size: 0.875rem;">For Fans Globally | Pay with BTC/ETH/USDT/SOL</span>
        </div>

        <h1 style="font-size: 2rem; font-weight: 900;">
          Get closer access to your favourite athletes & creators
        </h1>
        <p class="mx-auto" style="max-width: 700px; color: var(--ffm-text-secondary);">
          {{ $settings->title }} lets you build real connections with UFC fighters, bodybuilders, martial artists, fitness models and other creators through private chats, exclusive content, calls and video sessions.
        </p>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-md-3 col-6">
          <div class="text-center p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3);">
            <i class="bi bi-chat-dots text-orange mb-2" style="font-size: 1.5rem;"></i>
            <div class="fw-bold text-white mb-1">Personal Chats</div>
            <small style="color: var(--ffm-text-secondary);">Direct messaging with your favorite athletes</small>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="text-center p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(168, 85, 247, 0.3);">
            <i class="bi bi-lock text-purple mb-2" style="font-size: 1.5rem;"></i>
            <div class="fw-bold text-white mb-1">Exclusive Content</div>
            <small style="color: var(--ffm-text-secondary);">Premium photos, videos, and training materials</small>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="text-center p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3);">
            <i class="bi bi-telephone text-orange mb-2" style="font-size: 1.5rem;"></i>
            <div class="fw-bold text-white mb-1">Phone Calls</div>
            <small style="color: var(--ffm-text-secondary);">Voice conversations and coaching</small>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="text-center p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(168, 85, 247, 0.3);">
            <i class="bi bi-camera-video text-purple mb-2" style="font-size: 1.5rem;"></i>
            <div class="fw-bold text-white mb-1">Video Sessions</div>
            <small style="color: var(--ffm-text-secondary);">Face-to-face time with champions</small>
          </div>
        </div>
      </div>

      <div class="text-center">
        <a href="{{ $settings->registration_active == '1' ? url('signup') : url('login')}}" class="btn btn-lg btn-main btn-primary px-5 d-inline-flex align-items-center gap-2">
          <span>Sign Up as Fan - It's Free</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  {{-- ============================================
       FEATURED CREATORS SECTION
       ============================================ --}}
  @if ($settings->widget_creators_featured == 'on')
    @if ($users->count() != 0)
    <div class="section py-5">
      <div class="container">
        <div class="text-center mb-5">
          <h1 class="txt-black" style="font-size: 2rem; font-weight: 900;">{{__('general.creators_featured')}}</h1>
          <p style="color: var(--ffm-text-secondary);">{{__('general.desc_creators_featured')}}</p>
        </div>
        
        <div class="row">
          <div class="owl-carousel owl-theme">
            @foreach ($users as $response)
              @include('includes.listing-creators')
            @endforeach
          </div>

          @if (!$settings->disable_creators_section)
            @if ($usersTotal > $users->total())
            <div class="w-100 text-center mt-4">
              <a href="{{url('creators')}}" class="btn btn-lg btn-main btn-outline-light px-4">
                <i class="bi bi-people me-2"></i>{{__('general.view_all_creators')}}
              </a>
            </div>
            @endif
          @endif
        </div>
      </div>
    </div>
    @endif
  @endif

  {{-- ============================================
       STATS COUNTER SECTION
       ============================================ --}}
  @if ($settings->show_counter == 'on')
  <div class="section py-5 bg-gradient text-white">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="d-flex align-items-center justify-content-center p-4">
            <div class="me-4">
              <i class="bi bi-people display-4"></i>
            </div>
            <div>
              <h2 class="mb-0 fw-bold">{!! Helper::formatNumbersStats($usersTotal) !!}</h2>
              <h5 class="mb-0 opacity-90">{{__('general.creators')}}</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="d-flex align-items-center justify-content-center p-4">
            <div class="me-4">
              <i class="bi bi-images display-4"></i>
            </div>
            <div>
              <h2 class="mb-0 fw-bold">{!! Helper::formatNumbersStats(Updates::count()) !!}</h2>
              <h5 class="mb-0 opacity-90">{{__('general.content_created')}}</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="d-flex align-items-center justify-content-center p-4">
            <div class="me-4">
              <i class="bi bi-cash-coin display-4"></i>
            </div>
            <div>
              <h2 class="mb-0 fw-bold">
                @if($settings->currency_position == 'left') {{ $settings->currency_symbol }}@endif
                {!! Helper::formatNumbersStats(Transactions::whereApproved('1')->sum('earning_net_user')) !!}
                @if($settings->currency_position == 'right'){{ $settings->currency_symbol }} @endif
              </h2>
              <h5 class="mb-0 opacity-90">{{__('general.earnings_of_creators')}}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  {{-- ============================================
       BOTTOM CTA SECTION
       ============================================ --}}
  <section class="py-5" style="background: linear-gradient(to bottom right, #0B0F1A, #1f2937, #0B0F1A); position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(ellipse at 50% 50%, rgba(249, 115, 22, 0.15) 0%, transparent 70%); pointer-events: none;"></div>
    <div class="container text-center position-relative" style="z-index: 1;">
      <div class="mx-auto p-5 rounded-4" style="max-width: 700px; background: linear-gradient(to bottom right, rgba(30, 41, 59, 0.6), rgba(51, 65, 85, 0.4)); backdrop-filter: blur(20px); border: 1px solid rgba(51, 65, 85, 0.6); box-shadow: 0 25px 50px -12px rgba(249, 115, 22, 0.15);">
        <h1 style="font-size: 2rem; font-weight: 900; background: linear-gradient(to right, var(--ffm-orange-light), var(--ffm-orange), var(--ffm-purple)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
          Ready to start as a creator?
        </h1>
        <p class="mb-4" style="color: var(--ffm-text-secondary);">
          Keep more of what you earn, connect with fans in one place and unlock new media and casting opportunities as you grow on {{ $settings->title }}.
        </p>
        <a href="{{ $settings->registration_active == '1' ? url('signup') : url('login')}}" class="btn btn-lg btn-main btn-primary px-5 rounded-pill">
          <span>{{__('general.getting_started')}}</span>
        </a>
      </div>
    </div>
  </section>

@endsection

@section('javascript')
  @if (session('success_verify'))
  <script type="text/javascript">
    swal({
      title: "{{ __('general.welcome') }}",
      text: "{{ __('users.account_validated') }}",
      type: "success",
      confirmButtonText: "{{ __('users.ok') }}"
    });
  </script>
  @endif

  @if (session('error_verify'))
  <script type="text/javascript">
    swal({
      title: "{{ __('general.error_oops') }}",
      text: "{{ __('users.code_not_valid') }}",
      type: "error",
      confirmButtonText: "{{ __('users.ok') }}"
    });
  </script>
  @endif
@endsection
