@extends('layouts.appnew')

@section('title') Support Center - @endsection

@section('css')
  <script type="text/javascript">
      var error_scrollelement = {{ count($errors ?? []) > 0 ? 'true' : 'false' }};
  </script>
@endsection

@section('content')
  <section class="section section-sm" style="min-height: 80vh;">
    <div class="container">
      <div class="text-center mb-5">
        <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
          SUPPORT CENTER
        </span>
        <h1 style="font-size: 2.5rem; font-weight: 900;">We're Here to Help Support Center</h1>
        <p style="color: var(--ffm-text-secondary); max-width: 600px; margin: 0 auto;">
          Get the support you need to succeed on FansFollow. Our team is available to help you maximize your earnings and grow your community.
        </p>
      </div>

      <div class="row g-4 mb-5">
        <div class="col-md-3 col-6">
          <div class="text-center p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            <i class="bi bi-chat-dots" style="font-size: 2rem; color: var(--ffm-orange);"></i>
            <h3 style="font-size: 1rem; font-weight: 700; margin-top: 0.75rem;">Live Chat Support</h3>
            <p style="color: var(--ffm-text-secondary); font-size: 0.85rem;">Connect with our support team</p>
            <a href="javascript:void(0);" class="btn btn-sm mt-2" style="background: var(--cta-gradient); color: white; border-radius: 8px;">Start Chat</a>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="text-center p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            <i class="bi bi-envelope" style="font-size: 2rem; color: var(--ffm-purple);"></i>
            <h3 style="font-size: 1rem; font-weight: 700; margin-top: 0.75rem;">Email Support</h3>
            <p style="color: var(--ffm-text-secondary); font-size: 0.85rem;">support@fansfollow.me</p>
            <a href="mailto:support@fansfollow.me" class="btn btn-sm mt-2" style="background: rgba(255,255,255,0.1); color: white; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2);">Send Email</a>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="text-center p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            <i class="bi bi-book" style="font-size: 2rem; color: var(--ffm-orange);"></i>
            <h3 style="font-size: 1rem; font-weight: 700; margin-top: 0.75rem;">Help Center</h3>
            <p style="color: var(--ffm-text-secondary); font-size: 0.85rem;">Browse guides and resources</p>
            <a href="{{url('faq')}}" class="btn btn-sm mt-2" style="background: rgba(255,255,255,0.1); color: white; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2);">View Guides</a>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="text-center p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            <i class="bi bi-people" style="font-size: 2rem; color: var(--ffm-purple);"></i>
            <h3 style="font-size: 1rem; font-weight: 700; margin-top: 0.75rem;">Creator Community</h3>
            <p style="color: var(--ffm-text-secondary); font-size: 0.85rem;">Join our Discord</p>
            <a href="javascript:void(0);" class="btn btn-sm mt-2" style="background: rgba(255,255,255,0.1); color: white; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2);">Join Discord</a>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="text-center mb-4">
            <h2 style="font-size: 1.5rem; font-weight: 700;">Send Us a Message</h2>
            <p style="color: var(--ffm-text-secondary);">Fill out the form below and we'll get back to you as soon as possible.</p>
          </div>

          <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            @if (session('notification'))
              <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                {{ session('notification') }}
              </div>
            @endif

            @include('errors.errors-forms')

            <form method="POST" action="https://usebasin.com/f/954d0d6e30da" id="contactForm">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label style="color: var(--ffm-text-secondary); font-size: 0.85rem; margin-bottom: 0.5rem;">Full name *</label>
                    <input class="form-control" required value="{{Auth::user()->name ?? old('full_name')}}" placeholder="Your name" name="full_name" type="text" style="background: rgba(55,65,81,0.5); border: 1px solid rgba(75,85,99,0.5); border-radius: 8px; padding: 8px 12px; font-size: 14px;">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label style="color: var(--ffm-text-secondary); font-size: 0.85rem; margin-bottom: 0.5rem;">Email *</label>
                    <input name="email" required type="email" value="{{Auth::user()->email ?? old('email')}}" class="form-control" placeholder="your@email.com" style="background: rgba(55,65,81,0.5); border: 1px solid rgba(75,85,99,0.5); border-radius: 8px; padding: 8px 12px; font-size: 14px;">
                  </div>
                </div>
              </div>

              <div class="form-group mb-3">
                <label style="color: var(--ffm-text-secondary); font-size: 0.85rem; margin-bottom: 0.5rem;">Subject *</label>
                <input name="subject" required type="text" value="{{old('subject')}}" class="form-control" placeholder="How can we help?" style="background: rgba(55,65,81,0.5); border: 1px solid rgba(75,85,99,0.5); border-radius: 8px; padding: 8px 12px; font-size: 14px;">
              </div>

              <div class="form-group mb-3">
                <label style="color: var(--ffm-text-secondary); font-size: 0.85rem; margin-bottom: 0.5rem;">Message *</label>
                <textarea name="message" required rows="4" class="form-control" placeholder="Tell us more..." style="background: rgba(55,65,81,0.5); border: 1px solid rgba(75,85,99,0.5); border-radius: 8px; padding: 8px 12px; font-size: 14px;">{{old('message')}}</textarea>
              </div>

              @if ($settings->link_terms != '' && $settings->link_privacy != '')
              <div class="custom-control custom-checkbox mb-3">
                <input class="custom-control-input" required id="customCheckLogin" name="agree_terms_privacy" type="checkbox">
                <label class="custom-control-label" for="customCheckLogin" style="color: var(--ffm-text-secondary); font-size: 0.85rem;">
                  <span>{{trans('general.i_agree_with')}}
                    <a href="{{$settings->link_terms}}" target="_blank" style="color: var(--ffm-orange);">{{trans('admin.terms_conditions')}}</a>
                    {{trans('general.and')}} <a href="{{$settings->link_privacy}}" target="_blank" style="color: var(--ffm-orange);">{{trans('admin.privacy_policy')}}</a>
                  </span>
                </label>
              </div>
              @endif

              <div class="text-center">
                @if ($settings->captcha_contact == 'on')
                  {!! NoCaptcha::displaySubmit('contactForm', __('auth.send'), ['data-size' => 'invisible', 'class' => 'btn btn-primary my-4 w-100', 'style' => 'background: var(--cta-gradient); border-radius: 12px;']) !!}
                  {!! NoCaptcha::renderJs() !!}
                @else
                  <button type="submit" class="btn btn-primary my-4 w-100" style="background: var(--cta-gradient); border-radius: 12px;">{{__('auth.send')}}</button>
                @endif
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
