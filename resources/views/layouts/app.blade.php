<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('description_custom')@if(!Request::route()?->named('seo') && !Request::route()?->named('profile')){{trans('seo.description')}}@endif">
  <meta name="keywords" content="@yield('keywords_custom'){{ trans('seo.keywords') }}" />
  <meta name="theme-color" content="{{ config('settings.theme_color_pwa') }}">
  <title>{{ auth()->check() && User::notificationsCount() ? '('.User::notificationsCount().') ' : '' }}@section('title')@show {{$settings->title.' - '.__('seo.slogan')}}</title>
  <!-- Favicon -->
  <link href="{{ url('img', $settings->favicon) }}" rel="icon">

  @if ($settings->google_tag_manager_head != '')
  {!! $settings->google_tag_manager_head !!}
  @endif

  @include('includes.css_general')

  @if ($settings->status_pwa)
    @laravelPWA
  @endif

  @yield('css')

 @if ($settings->google_analytics != '')
  {!! $settings->google_analytics !!}
  @endif

  <!-- Microsoft Clarity -->
  <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i+"?ref=bwt";
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "xk78rrb386");
  </script>

  <!-- GA4 Event Tracking -->
  <script>
    function trackGA4Event(eventName, params) {
      if (typeof gtag === 'function') {
        gtag('event', eventName, params || {});
      }
    }
  </script>

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "FansFollow.me",
    "url": "https://fansfollowme.com",
    "logo": "https://staging.fansfollowme.com/fans-foloow-me-logo-final-file--png-version.png",
    "description": "FansFollowMe is the global fitness and martial arts creator platform for subscriptions, coaching, direct fan access, and live creator discovery.",
    "sameAs": [],
    "contactPoint": {
      "@type": "ContactPoint",
      "contactType": "customer service",
      "url": "https://staging.fansfollowme.com/support"
    }
  }
  </script>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "FansFollow.me",
    "url": "https://fansfollowme.com",
    "potentialAction": {
      "@type": "SearchAction",
      "target": {
        "@type": "EntryPoint",
        "urlTemplate": "https://staging.fansfollowme.com/explore?q={search_term_string}"
      },
      "query-input": "required name=search_term_string"
    }
  }
  </script>
</head>

<body>
  @if ($settings->google_tag_manager_body != '')
  {!! $settings->google_tag_manager_body !!}
  @endif

  @if ($settings->disable_banner_cookies == 'off')
  <div class="btn-block text-center showBanner padding-top-10 pb-3 display-none">
    <i class="fa fa-cookie-bite"></i> {{trans('general.cookies_text')}}
    @if ($settings->link_cookies != '')
      <a href="{{$settings->link_cookies}}" class="mr-2 text-white link-border" target="_blank">{{ trans('general.cookies_policy') }}</a>
    @endif
    <button class="btn btn-sm btn-primary" id="close-banner">{{trans('general.go_it')}}
    </button>
  </div>
@endif

  <div id="mobileMenuOverlay" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"></div>

  @auth
    @if (! request()->is('messages/*') && ! request()->is('live/*'))
    @include('includes.menu-mobile')
  @endif
  @endauth

  @if (auth()->guest() && $settings->alert_adult == 'on' && !$settings->age_verification_status)
    {{-- Age verification modal removed for debugging --}}
  @endif

  {{-- Age verification country check removed for debugging --}}

  <div class="popout popout-error font-default"></div>

@if (auth()->guest() && request()->path() == '/' && $settings->home_style == 0
    || auth()->guest() && request()->path() != '/' && $settings->home_style == 0
    || auth()->guest() && request()->path() != '/' && $settings->home_style == 1
    || auth()->guest() && request()->path() == '/' && $settings->home_style == 2
    || auth()->guest() && request()->path() != '/' && $settings->home_style == 2
    || auth()->check()
    )
  @include('includes.navbar')
  @endif

  <main @if (request()->is('messages/*') || request()->is('live/*')) class="h-100" @endif role="main">
    @yield('content')

    @if (auth()->guest() 
          && ! request()->route()?->named('profile')
          && ! request()->is(['creators', 'category/*', 'creators/*'])
          || auth()->check()
          && request()->path() != '/'
          && ! request()->route()?->named('profile')
          && ! request()->is([
            'my/bookmarks', 
            'my/likes', 
            'my/purchases', 
            'explore', 
            'messages', 
            'messages/*', 
            'creators', 
            'category/*', 
            'creators/*', 
            'live/*'
            ])          
          )

          @if (auth()->guest() && request()->path() == '/' && $settings->home_style == 0
                || auth()->guest() && request()->path() != '/' && $settings->home_style == 0
                || auth()->guest() && request()->path() != '/' && $settings->home_style == 1
                || auth()->guest() && request()->path() != '/' && $settings->home_style == 2
                || auth()->check()
                  )

                  @if (auth()->guest() && $settings->who_can_see_content == 'users')
                    <div class="text-center py-3 px-3">
                      @include('includes.footer-tiny')
                    </div>
                  @else
                    @include('includes.footer')
                  @endif

          @endif

  @endif

  @guest

  @if (Helper::showLoginFormModal())
      @include('includes.modal-login')
    @endif

  @endguest

  @auth

    @if ($settings->disable_tips == 'off')
     @include('includes.modal-tip')
   @endif

   @if ($settings->gifts)
     @include('includes.modal-gifts')
   @endif

    @include('includes.modal-payperview')

    @if ($settings->live_streaming_status == 'on')
      @include('includes.modal-live-stream')
    @endif

    @if ($settings->allow_scheduled_posts)
      @include('includes.modal-scheduled-posts')
    @endif

    @if ($settings->video_call_status)
      @include('includes.modal-video-call-incoming')
    @endif

    @if ($settings->audio_call_status)
      @include('includes.modal-audio-call-incoming')
    @endif

    @if ($settings->allow_vault)
      @include('includes.modal-vault')
    @endif

    @if ($settings->allow_crowdfund)
      @include('includes.modal-crowdfund')
      @include('includes.modal-donate')
      @include('includes.modal-donors')
    @endif
    
  @endauth

  @guest
    @include('includes.modal-2fa')
  @endguest
</main>

  @include('includes.javascript_general')

  @yield('javascript')
  
@auth
  <div id="bodyContainer"></div>
@endauth
</body>
</html>
