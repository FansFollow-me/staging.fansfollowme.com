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
    <div class="modal fade" tabindex="-1" id="alertAdult">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body p-4">
            <p>{{ __('general.alert_content_adult') }}</p>
          </div>
          <div class="modal-footer border-0 pt-0">
            <a href="https://google.com" class="btn e-none p-0 mr-3">{{trans('general.leave')}}</a>
            <button type="button" class="btn btn-primary" id="btnAlertAdult">{{trans('general.i_am_age')}}</button>
          </div>
        </div>
      </div>
    </div>
  @endif

  @php
    $countries = config('settings.age_verification_countries');
    $shouldShowForCountry = $countries
        ? in_array(Helper::userCountry(), explode(',', $countries))
        : true;
  @endphp

  @if (auth()->guest() 
    && $settings->age_verification_status 
    && $settings->show_modal_age_verification 
    && !request()->is(['login', 'signup', 'password/reset*'])
    && $shouldShowForCountry
    )
    <div class="modal fade" tabindex="-1" id="alertAgeVerification">
      <div class="modal-dialog">
        <div class="modal-content text-center">
          <div class="modal-body pt-4 px-4 pb-0">
            <h2><i class="fa fa-exclamation-triangle mb-2 text-warning"></i></h2>
            <h4>
              {{ __('general.alert_age_verification_title') }}
            </h4>
            <p>{{ __('general.alert_age_verification') }}</p>
          </div>
          <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
            <button type="button" 
            
            @if ($settings->home_style == 1 && request()->path() == '/') 
              data-dismiss="modal" 
              class="btn btn-primary"

              @else
              data-toggle="modal" data-target="#loginFormModal"
              class="btn btn-primary toggleRegister"
            @endif
            >
            {{__('general.start_age_verification')}}
          </button>
          </div>
        </div>
      </div>
    </div>
  @endif

  @yield('content')
</main>
</body>
</html>
