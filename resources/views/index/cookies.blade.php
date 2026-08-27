@extends('layouts.appnew')

@section('title') Cookie Policy - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <a href="{{url('/')}}" class="btn btn-sm btn-outline-secondary mb-4"><i class="feather icon-arrow-left mr-1"></i> Back to Home</a>
        
        <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange);">COOKIE POLICY</span>
        
        <h1 class="mb-3" style="font-size: 2.5rem; font-weight: 900;">How We Use Cookies</h1>
        
        <p style="color: var(--ffm-text-secondary);">At {{$settings->title}}, we use cookies and similar technologies to improve your browsing experience and to personalize the content and advertisements that you see on our website.</p>
        
        <p class="mb-5"><small style="color: var(--ffm-text-muted);">Last updated: January 22, 2025</small></p>

        <div class="content-p">
          <div class="p-3 rounded-3 my-4" style="background: rgba(249, 115, 22, 0.1); border-left: 4px solid var(--ffm-orange);">
            <strong>🍪 By using {{$settings->title}}, you acknowledge that you have read and understand this Cookies Policy and agree to be bound by it.</strong>
          </div>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">What Are Cookies?</h3>
          <p>Cookies are small text files that are stored on your device when you visit a website. They are used to remember your preferences and to track your browsing activity. Cookies help us remember your preferences, keep you logged in, and provide a better user experience.</p>

          <div class="row g-3 my-4">
            <div class="col-md-6">
              <div class="p-3 rounded-3" style="background: rgba(249, 115, 22, 0.1);">
                <h6 class="fw-bold">Session Cookies</h6>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Temporary cookies that are deleted when you close your browser. Used for essential site functionality.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-3" style="background: rgba(168, 85, 247, 0.1);">
                <h6 class="fw-bold">Persistent Cookies</h6>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Remain on your device until they expire or you delete them. Used to remember your preferences.</p>
              </div>
            </div>
          </div>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">How We Use Cookies</h3>
          <p>We use cookies to:</p>

          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="fw-bold">Essential Cookies <span class="badge badge-pill px-2 py-1" style="background: rgba(249, 115, 22, 0.2); color: var(--ffm-orange); font-size: 0.7rem;">REQUIRED</span></h5>
              <p class="mb-0" style="color: var(--ffm-text-secondary);">These cookies are necessary for the website to function and cannot be switched off.</p>
              <ul class="mt-2" style="color: var(--ffm-text-secondary);">
                <li>Authentication and login sessions</li>
                <li>Security and fraud prevention</li>
                <li>Payment processing</li>
                <li>Site functionality and navigation</li>
              </ul>
            </div>
          </div>

          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="fw-bold">Performance & Analytics Cookies <span class="badge badge-pill px-2 py-1" style="background: rgba(168, 85, 247, 0.2); color: var(--ffm-purple); font-size: 0.7rem;">OPTIONAL</span></h5>
              <p class="mb-0" style="color: var(--ffm-text-secondary);">Help us understand how visitors use our site to improve performance and analyze website usage.</p>
              <ul class="mt-2" style="color: var(--ffm-text-secondary);">
                <li>Track how our website is used and identify errors</li>
                <li>Collect information about pages visited and actions taken</li>
                <li>Performance monitoring and optimization</li>
                <li>Usage statistics (anonymized)</li>
              </ul>
            </div>
          </div>

          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="fw-bold">Personalization Cookies <span class="badge badge-pill px-2 py-1" style="background: rgba(168, 85, 247, 0.2); color: var(--ffm-purple); font-size: 0.7rem;">OPTIONAL</span></h5>
              <p class="mb-0" style="color: var(--ffm-text-secondary);">Remember your preferences and personalize your experience on the platform.</p>
              <ul class="mt-2" style="color: var(--ffm-text-secondary);">
                <li>Remember your preferences and settings</li>
                <li>Personalized content recommendations</li>
                <li>Language and region preferences</li>
                <li>Theme and display preferences</li>
              </ul>
            </div>
          </div>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Managing Cookies</h3>
          <p>You can control and manage cookies through your browser settings. Please note that disabling certain cookies may affect the functionality of the website.</p>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Contact Us</h3>
          <p>If you have questions about our use of cookies, contact us at <a href="mailto:support@fansfollow.me" style="color: var(--ffm-orange);">support@fansfollow.me</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
