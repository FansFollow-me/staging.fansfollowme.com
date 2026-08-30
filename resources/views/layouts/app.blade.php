<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@section('title')@show {{ $settings->title }}</title>
@include('includes.css_general')
@yield('css')

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "FansFollow.me",
  "url": "https://fansfollowme.com",
  "description": "FansFollowMe is the global fitness and martial arts creator platform for subscriptions, coaching, direct fan access, and live creator discovery.",
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

<!-- GA4 Event Tracking -->
<script>
  function trackGA4Event(eventName, params) {
    if (typeof gtag === 'function') {
      gtag('event', eventName, params || {});
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
  <button class="btn btn-sm btn-primary" id="close-banner">{{trans('general.go_it')}}</button>
</div>
@endif

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
          <h4>{{ __('general.alert_age_verification_title') }}</h4>
          <p>{{ __('general.alert_age_verification') }}</p>
        </div>
        <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
          <button type="button" class="btn btn-primary toggleRegister" data-toggle="modal" data-target="#loginFormModal">
            {{__('general.start_age_verification')}}
          </button>
        </div>
      </div>
    </div>
  </div>
@endif

@auth
@if (! request()->is('messages/*') && ! request()->is('live/*'))
@include('includes.menu-mobile')
@endif
@endauth

@include('includes.navbar')
<main role="main">
@yield('content')

@if (auth()->check() || $settings->who_can_see_content == 'all')
  @if (auth()->guest() && $settings->who_can_see_content == 'users')
    <div class="text-center py-3 px-3">
      @include('includes.footer-tiny')
    </div>
  @else
    @include('includes.footer')
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
</body>
</html>
