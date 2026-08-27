@extends('layouts.appnew')

@section('title') FAQ - Frequently Asked Questions - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <h1 class="mb-3" style="font-size: 2.5rem; font-weight: 900;">Frequently Asked Questions</h1>
        <p class="lead" style="color: var(--ffm-text-secondary); max-width: 600px; margin: 0 auto;">
          Everything you need to know about {{$settings->title}} - creator earnings, payments, and platform features.
        </p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        {{-- Getting Started --}}
        <h3 class="mb-4" style="font-weight: 800;">Getting Started</h3>
        <div class="accordion mb-5" id="faqGettingStarted">
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq1">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq1a">
                  How much does it cost to join as a creator?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq1a" class="collapse" data-parent="#faqGettingStarted">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                It's completely free to join {{$settings->title}} as a creator. There are no upfront fees or monthly charges. We only take a small commission when you earn, so you only pay when you get paid.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq2">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq2a">
                  How much does it cost for fans?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq2a" class="collapse" data-parent="#faqGettingStarted">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                Signing up as a fan is free. You only pay for the content, subscriptions, or services you choose to purchase from creators. There are no hidden fees or mandatory subscriptions.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq3">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq3a">
                  Do I need a large following to start earning?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq3a" class="collapse" data-parent="#faqGettingStarted">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                No! {{$settings->title}} is designed to help creators at any stage. Even with a small but engaged audience, you can start earning through subscriptions, paid messages, and coaching sessions. Many creators see their first earnings within 24-48 hours.
              </div>
            </div>
          </div>
        </div>

        {{-- Payments & Earnings --}}
        <h3 class="mb-4" style="font-weight: 800;">Payments & Earnings</h3>
        <div class="accordion mb-5" id="faqPayments">
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq4">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq4a">
                  How do I get paid?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq4a" class="collapse" data-parent="#faqPayments">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                You can receive payouts via bank transfer or cryptocurrency (BTC, ETH, USDT, SOL). We process payouts regularly with low fees and fast processing times.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq5">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq5a">
                  What's the revenue split?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq5a" class="collapse" data-parent="#faqPayments">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                Creators keep 80%+ of all earnings. This is one of the most creator-friendly revenue shares in the industry. Large creators can negotiate even higher rates.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq6">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq6a">
                  What are the revenue streams?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq6a" class="collapse" data-parent="#faqPayments">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                {{$settings->title}} offers 21+ revenue streams including subscriptions, paid chats, phone calls, video sessions, tips, paid posts, live streaming, coaching, training programs, meal plans, product sales, and more.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq7">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq7a">
                  How often do I get paid?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq7a" class="collapse" data-parent="#faqPayments">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                Payouts are processed regularly. You can request a payout once you reach the minimum threshold, and funds are typically delivered within a few business days depending on your chosen payment method.
              </div>
            </div>
          </div>
        </div>

        {{-- Platform Features --}}
        <h3 class="mb-4" style="font-weight: 800;">Platform Features</h3>
        <div class="accordion mb-5" id="faqFeatures">
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq8">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq8a">
                  Can I use this alongside other platforms?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq8a" class="collapse" data-parent="#faqFeatures">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                Absolutely! {{$settings->title}} is designed to complement your existing platforms. Many creators use it alongside Instagram, YouTube, TikTok, and other social media to monetize their audience more effectively.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq9">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq9a">
                  What countries are supported?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq9a" class="collapse" data-parent="#faqFeatures">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                {{$settings->title}} is available worldwide. Creators and fans from any country can join. We support multiple currencies and payment methods including cryptocurrency for global accessibility.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq10">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq10a">
                  Is my content safe and secure?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq10a" class="collapse" data-parent="#faqFeatures">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                Yes! We use encrypted messaging, secure payment processing, and robust content protection measures. Your content and personal information are protected with industry-standard security.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq11">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq11a">
                  What kind of content can I post?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq11a" class="collapse" data-parent="#faqFeatures">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                {{$settings->title}} is focused on fitness, bodybuilding, nutrition, martial arts, and combat sports content. You can post training videos, workout routines, nutrition plans, behind-the-scenes content, personal updates, and more.
              </div>
            </div>
          </div>
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq12">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq12a">
                  Can I offer private coaching or consultations?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq12a" class="collapse" data-parent="#faqFeatures">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                Yes! Private coaching and consultations are one of our most popular features. You can offer paid phone calls, video sessions, text coaching, and personalized training programs directly through the platform.
              </div>
            </div>
          </div>
        </div>

        {{-- Technical --}}
        <h3 class="mb-4" style="font-weight: 800;">Technical</h3>
        <div class="accordion mb-5" id="faqTechnical">
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0" id="faq13">
              <h5 class="mb-0">
                <button class="btn btn-link text-left w-100 text-decoration-none fw-semibold" style="color: var(--ffm-text-primary);" data-toggle="collapse" data-target="#faq13a">
                  Is there a mobile app?
                  <i class="feather icon-chevron-down float-right"></i>
                </button>
              </h5>
            </div>
            <div id="faq13a" class="collapse" data-parent="#faqTechnical">
              <div class="card-body" style="color: var(--ffm-text-secondary);">
                {{$settings->title}} is a Progressive Web App (PWA) that works seamlessly on mobile devices. You can install it on your phone's home screen for an app-like experience without needing to download from an app store.
              </div>
            </div>
          </div>
        </div>

        {{-- Still have questions --}}
        <div class="text-center py-5">
          <h3 class="mb-3" style="font-weight: 800;">Still have questions?</h3>
          <p style="color: var(--ffm-text-secondary);">Our support team is here to help. Reach out anytime.</p>
          <a href="{{url('contact')}}" class="btn btn-lg btn-main btn-primary px-5 rounded-pill">Contact Support</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
