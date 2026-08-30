<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@section('title')@show {{ $settings->title }}</title>
@include('includes.css_general')
@yield('css')
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

@include('includes.navbar')
<main role="main">
@yield('content')
@include('includes.footer')

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
