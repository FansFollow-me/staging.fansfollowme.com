@extends('layouts.app')

@section('title') Terms of Service - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <a href="{{url('/')}}" class="btn btn-sm btn-outline-secondary mb-4"><i class="feather icon-arrow-left mr-1"></i> Back to Home</a>
        
        <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange);">TERMS OF SERVICE</span>
        
        <h1 class="mb-3" style="font-size: 2.5rem; font-weight: 900;">Platform Terms & Conditions</h1>
        
        <p style="color: var(--ffm-text-secondary);">Welcome to {{$settings->title}}! These terms govern your use of our platform and outline the rights and responsibilities of creators, fans, and our community.</p>
        
        <p class="mb-5"><small style="color: var(--ffm-text-muted);">Last updated: January 22, 2025</small></p>

        <div class="content-p">
          <h3 class="mt-5 mb-3" style="font-weight: 800;">Introduction</h3>
          <p>Welcome to {{$settings->title}} (the "Site" or "Platform"). By using the Site, you agree to be bound by these Terms of Service (the "Terms") and our Privacy Policy. If you do not agree to these Terms or the Privacy Policy, you may not use the Site.</p>
          
          <div class="p-3 rounded-3 my-4" style="background: rgba(249, 115, 22, 0.1); border-left: 4px solid var(--ffm-orange);">
            <strong>By using {{$settings->title}}, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.</strong>
          </div>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Platform Usage</h3>
          
          <h5 class="mt-4 mb-2 fw-semibold">Eligibility</h5>
          <p>You must be at least 18 years old to use {{$settings->title}}. By creating an account, you confirm you meet this requirement.</p>

          <h5 class="mt-4 mb-2 fw-semibold">Account Responsibility</h5>
          <p>You're responsible for maintaining the security of your account and all activities that occur under your account. You agree to provide accurate information and keep your account details up to date.</p>

          <h5 class="mt-4 mb-2 fw-semibold">Acceptable Use</h5>
          <p>Use {{$settings->title}} for its intended purpose: connecting creators with fans through content and personal interactions in fitness, nutrition, martial arts, and combat sports.</p>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">User Content & Intellectual Property</h3>
          
          <h5 class="mt-4 mb-2 fw-semibold">Content Licensing</h5>
          <p>The Site allows users to post, upload, or otherwise submit content (the "User Content"). By submitting User Content, you grant {{$settings->title}} a non-exclusive, royalty-free, perpetual, irrevocable, and fully sublicensable right to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, and display the User Content throughout the world in any media.</p>

          <h5 class="mt-4 mb-2 fw-semibold">Intellectual Property Protection</h5>
          <p>The Site, including all content, text, images, logos, and trademarks, is owned by {{$settings->title}} and is protected by copyright, trademark, and other intellectual property laws.</p>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Payments & Earnings</h3>
          <ul>
            <li>Creators keep 80%+ of all earnings generated through the platform</li>
            <li>Payment processing fees may apply depending on your chosen payout method</li>
            <li>Payouts are processed according to our payment schedule</li>
            <li>You are responsible for any taxes on your earnings</li>
          </ul>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Prohibited Activities</h3>
          <p>You agree not to:</p>
          <ul>
            <li>Use the platform for any illegal purpose</li>
            <li>Share content that violates intellectual property rights</li>
            <li>Harass, abuse, or harm other users</li>
            <li>Attempt to circumvent platform security measures</li>
            <li>Create multiple accounts for deceptive purposes</li>
            <li>Use automated systems to access the platform without permission</li>
          </ul>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Limitation of Liability</h3>
          <p>{{$settings->title}} shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of the platform.</p>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Changes to Terms</h3>
          <p>We reserve the right to modify these Terms at any time. We will notify users of significant changes. Continued use of the platform after changes constitutes acceptance of the new Terms.</p>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Contact</h3>
          <p>If you have questions about these Terms, contact us at <a href="mailto:support@fansfollow.me" style="color: var(--ffm-orange);">support@fansfollow.me</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
